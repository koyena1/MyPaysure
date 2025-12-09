<?php
session_start();

// --- 1. DATABASE CONNECTION ---
include '../includes/db.php';

// Ensure $pdo variable is available (handles case if db.php uses $db)
if (!isset($pdo) && isset($db)) {
    $pdo = $db;
}

// --- 2. SECURITY CHECK ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit;
}

// --- 3. REAL GROWTH GRAPH LOGIC (Audio Based: Business Volume & Comparison) ---
$months = [];
$companyData = [];
$selfData = [];
$current_member_id = $_SESSION['username']; 

// We assume an average joining package value to calculate "Company Business Volume"
// You can change this 5000 to your actual package price.
$avg_package_price = 5000; 

// Loop through the last 6 months
for ($i = 5; $i >= 0; $i--) {
    $monthLabel = date('M Y', strtotime("-$i months")); // e.g., "Oct 2023"
    $monthQuery = date('Y-m', strtotime("-$i months")); // e.g., "2023-10"
    $months[] = $monthLabel;

    // A. Company Business: (Total Joinings * Price) = Total Volume
    // The audio emphasizes "Company Business" (e.g., 10 Lakhs), not just counts.
    try {
        $stmt = $pdo->prepare("SELECT COUNT(id) FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = ?");
        $stmt->execute([$monthQuery]);
        $count = $stmt->fetchColumn() ?: 0;
        $companyData[] = $count * $avg_package_price; 
    } catch (Exception $e) {
        $companyData[] = 0;
    }

    // B. Self Business: Sum of Commissions/Earnings
    // The audio emphasizes "My Business" (e.g., 1 Lakh)
    try {
        $stmt = $pdo->prepare("SELECT SUM(total_payable_commission) FROM user_paid_unpaid_report WHERE member_id = ? AND DATE_FORMAT(payment_date, '%Y-%m') = ?");
        $stmt->execute([$current_member_id, $monthQuery]);
        $selfData[] = $stmt->fetchColumn() ?: 0;
    } catch (Exception $e) {
        $selfData[] = 0;
    }
}

// Prepare JSON for JavaScript
$jsLabels = json_encode($months);
$jsCompanyData = json_encode($companyData);
$jsSelfData = json_encode($selfData);


// --- 4. IMAGE UPLOAD LOGIC ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    
    if ($file['error'] === 0) {
        $uploadDir = 'uploads/profile/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array(strtolower($ext), $allowed)) {
            $newFilename = "user_" . $_SESSION['user_id'] . "_" . time() . "." . $ext;
            $destination = $uploadDir . $newFilename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $stmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
                $stmt->execute([$newFilename, $_SESSION['user_id']]);
                
                $_SESSION['profile_image'] = $newFilename;
                
                header("Location: client_dashboard.php");
                exit;
            }
        }
    }
}

// --- 5. DETERMINE WHICH IMAGE TO SHOW ---
$userImage = "https://i.pravatar.cc/150?u=" . $_SESSION['username']; 
if (!empty($_SESSION['profile_image']) && file_exists('uploads/profile/' . $_SESSION['profile_image'])) {
    $userImage = 'uploads/profile/' . $_SESSION['profile_image'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* --- 1. General Reset & Variables --- */
        :root {
            --bg-color: #FFF5EB;
            --sidebar-bg: #ffffff;
            --text-main: #333;
            --text-light: #888;
            --accent-orange: #FF8C32;
            --accent-green: #2DCD85;
            --accent-blue: #5AB6D8;
            --accent-red: #F7525F;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background-color: var(--bg-color);
            display: flex;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* --- 2. Sidebar Styling --- */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            padding: 30px 20px;
            margin: 20px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 24px;
            font-weight: bold;
        }

        .logo img { width: 32px; height: auto; }

        .sidebar-close-btn {
            display: none;
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-light);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 10px;
            transition: 0.3s;
            font-weight: 500;
            cursor: pointer;
        }

        .menu-item i.menu-icon { width: 25px; margin-right: 10px; }

        .menu-item.active {
            background-color: var(--accent-orange);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 140, 50, 0.3);
        }

        .menu-item:hover:not(.active) {
            background-color: #f8f8f8;
            color: var(--accent-orange);
        }

        /* --- NEW SIDEBAR SUBMENU STYLES --- */
        .sidebar-submenu {
            display: none;
            flex-direction: column;
            padding-left: 50px;
            gap: 5px;
            margin-top: -10px;
            margin-bottom: 5px;
        }

        .sidebar-submenu.show { display: flex; }

        .sidebar-submenu a {
            text-decoration: none;
            font-size: 13px;
            color: var(--text-light);
            transition: 0.2s;
            padding: 5px 0;
        }

        .sidebar-submenu a:hover { color: var(--accent-orange); }

        /* --- 3. Main Content Area --- */
        .main-content {
            flex: 1;
            padding: 20px 30px 20px 10px;
            overflow-y: auto;
            transition: 0.3s;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-left { display: flex; align-items: center; gap: 15px; }

        .menu-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-main);
        }

        .header h2 { font-size: 22px; }

        .search-bar {
            background: white;
            padding: 10px 20px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            width: 300px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            margin-left: 10px;
            color: var(--text-light);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* --- PROFILE STYLES --- */
        .profile { display: flex; align-items: center; gap: 10px; }

        #profileForm { display: flex; align-items: center; margin: 0; }

        .profile-upload-container {
            position: relative;
            width: 40px !important;
            height: 40px !important;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            display: block;
        }

        .profile-upload-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-overlay {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center; justify-content: center;
            color: white; font-size: 12px;
        }
        
        .profile-upload-container:hover .profile-overlay { display: flex; }

        .profile-dropdown-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 35px;
            background-color: white;
            min-width: 140px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            z-index: 1001;
            overflow: hidden;
        }

        .profile-dropdown-content a {
            color: var(--text-main);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: 0.2s;
        }

        .profile-dropdown-content a:hover {
            background-color: #f8f8f8;
            color: var(--accent-orange);
        }

        .profile-dropdown-content.show { display: block; }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .icon-green { background-color: var(--accent-green); }
        .icon-blue { background-color: var(--accent-blue); }
        .icon-red { background-color: var(--accent-red); }

        .card-info { flex-grow: 1; }
        .card-info h3 { font-size: 16px; color: var(--text-main); }
        .card-info h2 { font-size: 20px; margin: 5px 0; }
        .card-info span { font-size: 12px; color: var(--accent-orange); white-space: nowrap; }
        .date-label { margin-left: auto; font-size: 12px; color: #aaa; align-self: flex-start; }

        /* Charts Section */
        .charts-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            padding-bottom: 20px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            width: 100%;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .legend-dots span {
            font-size: 12px;
            margin-left: 10px;
            color: var(--text-light);
            white-space: nowrap;
        }
        .dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 900;
        }

        /* --- MEDIA QUERIES --- */
        @media (max-width: 1024px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .charts-container { grid-template-columns: 1fr; }
            .sidebar { width: 220px; }
        }

        @media (max-width: 768px) {
            body { display: block; height: auto; overflow-x: hidden; }
            .main-content { padding: 20px; height: 100vh; }
            .sidebar {
                position: fixed; top: 0; left: -280px; height: 100vh;
                margin: 0; width: 260px; border-radius: 0 20px 20px 0;
            }
            .sidebar.active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .menu-toggle { display: block; }
            .sidebar-close-btn { display: block; }
            .header { flex-wrap: wrap; gap: 15px; }
            .header-left { width: 100%; justify-content: space-between; }
            .search-bar { width: 100%; order: 3; }
            .user-actions { margin-left: auto; }
            .stats-row { grid-template-columns: 1fr; }
            .card { padding: 15px; }
            .user-actions img[alt="UK"] { display: none; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-close-btn" onclick="toggleSidebar()">
            <i class="fa-solid fa-xmark"></i>
        </div>

        <div class="logo">
            <img src="../assets/images/logo.png" alt="Logo">
            Paysure
        </div>

        <a href="client_dashboard.php" class="menu-item active">
            <i class="fa-solid fa-house menu-icon"></i> Dashboard
        </a>
        
        <div style="position: relative;">
            <a href="my_profile.php" class="menu-item">
                <i class="fa-solid fa-user menu-icon"></i> Profile
            </a>
            
            <div onclick="toggleSidebarProfile()" style="position: absolute; right: 0; top: 0; height: 100%; width: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #888;"></i>
            </div>
        </div>

        <div class="sidebar-submenu" id="sidebarProfileMenu">
            <a href="edit_profile.php">Edit Profile</a>
            <a href="welcome_letter.php">Welcome Letter</a>
        </div>
        
        <div style="position: relative;">
            <a href="#" class="menu-item">
                <i class="fa-solid fa-user menu-icon"></i> Members
            </a>
            
            <div onclick="toggleSidebarMembers()" style="position: absolute; right: 0; top: 0; height: 100%; width: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #888;"></i>
            </div>
        </div>

        <div class="sidebar-submenu" id="sidebarMembersMenu">
            <a href="genealogy_tree.php">Genealogy</a>
        </div>

        <a href="sponsor_bonus.php" class="menu-item">
            <i class="fa-solid fa-money-bill-transfer menu-icon"></i> Insurance Details
        </a>
        <a href="matching_bonus.php" class="menu-item">
            <i class="fa-solid fa-user-shield menu-icon"></i> Investment
        </a>
        <a href="kyc_upload.php" class="menu-item">
            <i class="fa-solid fa-building menu-icon"></i> Business
        </a>
        <a href="#" class="menu-item">
          <i class="fa-solid fa-wallet menu-icon"></i> Wallet
        </a>
        
    </div>

    <div class="main-content">
        
        <div class="header">
            <div class="header-left">
                <div class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h2>Dashboard</h2>
            </div>

            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color:#ccc;"></i>
                <input type="text" placeholder="Search...">
            </div>
            
            <div class="user-actions">
                <img src="https://upload.wikimedia.org/wikipedia/en/thumb/a/ae/Flag_of_the_United_Kingdom.svg/1200px-Flag_of_the_United_Kingdom.svg.png" width="25" alt="UK">
                <i class="fa-solid fa-bell" style="color: #333;"></i>
               
                <div class="profile">
                    <form action="" method="POST" enctype="multipart/form-data" id="profileForm">
                        <label for="profileUpload" class="profile-upload-container">
                            <img src="<?php echo htmlspecialchars($userImage); ?>" alt="User">
                            <div class="profile-overlay">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                        </label>
                        <input type="file" name="profile_image" id="profileUpload" style="display: none;" onchange="document.getElementById('profileForm').submit();">
                    </form>
                    
                    <div class="profile-dropdown-wrapper" onclick="toggleProfileMenu()">
                        <span style="font-size: 14px; font-weight: 500;" class="user-name-text">
                            <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                        </span>
                        <i class="fa-solid fa-caret-down"></i>
                        
                        <div id="profileDropdown" class="profile-dropdown-content">
                            <a href="my_profile.php">Edit Profile</a>
                        </div>
                    </div>
                    <a href="../logout.php" style="margin-left: 10px; color: #F7525F;"><i class="fa-solid fa-power-off"></i></a>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-calendar-day"></i></div>
                <div class="card-info">
                    <h3>Activation Date</h3>
                    <h2>23/05/2022</h2>
                    <span><i class="fa-solid fa-check-circle"></i> Active</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-user-group"></i></div>
                <div class="card-info">
                    <h3>Team Members</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                <div class="card-info">
                    <h3>Sponsored</h3>
                    <h2>₹2,300</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +210% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-chart-line"></i></div>
                <div class="card-info">
                    <h3>Self Investment</h3>
                    <h2>₹4,000</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="card-info">
                    <h3>Monthly PayOuts</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                <div class="card-info">
                    <h3>Sponsored Investment</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-chart-pie"></i></div>
                <div class="card-info">
                    <h3>Business Ratio</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-handshake"></i></div>
                <div class="card-info">
                    <h3>Team Business</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-money-bill-transfer"></i></div>
                <div class="card-info">
                    <h3>Total Bank PayOut</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-dollar-sign"></i></div>
                <div class="card-info">
                    <h3>Total Income</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>

            <div class="card">
                <div class="icon-box icon-red"><i class="fa-solid fa-coins"></i></div>
                <div class="card-info">
                    <h3>Remaining Principle</h3>
                    <h2>3,200</h2>
                    <span><i class="fa-solid fa-arrow-trend-up"></i> +12% last month</span>
                </div>
            </div>
        </div>

        <div class="charts-container">
            
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Business Growth Analysis</h3>
                    <div class="legend-dots">
                        <span><span class="dot" style="background:#2DCD85"></span> Company Business (Volume)</span>
                        <span><span class="dot" style="background:#FF8C32"></span> My Business (Income)</span>
                    </div>
                </div>
                <canvas id="growthChart"></canvas>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3>Website Visitors</h3>
                </div>
                <div style="position: relative; height: 200px; width: 100%;">
                    <canvas id="visitorChart"></canvas>
                </div>
                <div style="margin-top: 20px; display: flex; justify-content: space-between; font-size: 14px; color: #666;">
                    <span><span class="dot" style="background:#FF8C32"></span> Direct</span>
                    <span style="font-weight: bold; color: #333;">38%</span>
                </div>
            </div>
        </div>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function toggleSidebarProfile() {
            const menu = document.getElementById('sidebarProfileMenu');
            menu.classList.toggle('show');
        }

        function toggleSidebarMembers() {
            const menu = document.getElementById('sidebarMembersMenu');
            menu.classList.toggle('show');
        }

        function toggleProfileMenu() {
            const dropdown = document.getElementById("profileDropdown");
            dropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.closest('.profile-dropdown-wrapper')) {
                var dropdowns = document.getElementsByClassName("profile-dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        // --- REAL DATA CHART CONFIGURATION (Matches Audio Requirements) ---
        
        // 1. Get Data from PHP
        const chartLabels = <?php echo $jsLabels; ?>; 
        const companyData = <?php echo $jsCompanyData; ?>; 
        const selfData = <?php echo $jsSelfData; ?>;

        const ctx1 = document.getElementById('growthChart').getContext('2d');
        
        // This configuration uses TWO Y-Axes.
        // As per the audio: If company has 10 Lakhs and User has 1 Lakh, 
        // a single axis makes the User line look flat.
        // Two axes allow us to compare the GROWTH RATE (Inclination) side-by-side.
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Company Business',
                        data: companyData,
                        borderColor: '#2DCD85',
                        backgroundColor: 'rgba(45, 205, 133, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2DCD85',
                        fill: true,
                        yAxisID: 'y' // Left Axis
                    },
                    {
                        label: 'My Business',
                        data: selfData,
                        borderColor: '#FF8C32',
                        backgroundColor: 'rgba(255, 140, 50, 0.1)', 
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#FF8C32',
                        fill: true,
                        yAxisID: 'y1' // Right Axis
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    return label + '₹' + context.parsed.y.toLocaleString();
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Company Volume (₹)' },
                        grid: { borderDash: [5, 5], color: '#eee' },
                        ticks: {
                            callback: function(value) { return '₹' + (value/100000).toFixed(1) + 'L'; } // Shows in Lakhs
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'My Income (₹)' },
                        grid: { drawOnChartArea: false },
                        ticks: {
                            callback: function(value) { return '₹' + value; }
                        }
                    }
                }
            }
        });

        // 2. Visitor Donut Chart
        const ctx2 = document.getElementById('visitorChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Organic', 'Social', 'Referral'],
                datasets: [{
                    data: [38, 22, 15, 25],
                    backgroundColor: ['#FF8C32', '#2DCD85', '#5AB6D8', '#F7525F'],
                    borderWidth: 5,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>