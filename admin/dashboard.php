<?php
session_start();
require '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Database configuration


if (isset($_POST['upload_profile'])) {
    $image = $_FILES['profile_image'];
    if ($image['error'] === 0) {
        $uploadDir = "uploads/profile/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = "profile_" . $_SESSION['user_id'] . "." . $ext;
        $path = $uploadDir . $filename;
        if (move_uploaded_file($image['tmp_name'], $path)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_image=? WHERE id=?");
            $stmt->execute([$filename, $_SESSION['user_id']]);
            $_SESSION['profile_image'] = $filename;
            $_SESSION['success'] = "Profile image updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to upload image. Please check directory permissions.";
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paysure | Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            --sidebar-glass: rgba(15, 23, 42, 0.85);
            --primary: #3b82f6;
            --text-primary: #1e293b;
            --text-muted: #64748b;
            --success: #10b981;
            --danger: #ef4444;
        }

        body.dark-mode {
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            --sidebar-glass: rgba(15, 23, 42, 0.95);
            --text-primary: #f1f5f9;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        body.dark-mode {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        /* Layout */
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar-glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-right: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 20px 10px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 15px 25px 15px;
            font-size: 20px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .logo img { width: 40px; height: 40px; object-fit: contain; }

        .nav-menu { list-style: none; }
        .nav-item { margin-bottom: 4px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .nav-icon { width: 20px; height: 20px; }
        .arrow-icon { margin-left: auto; transition: transform 0.3s; opacity: 0.7; }
        .nav-item.active .arrow-icon { transform: rotate(90deg); color: var(--primary); }

        /* Submenu */
        .submenu {
            list-style: none;
            display: none;
            background: rgba(0,0,0,0.2);
            border-radius: 12px;
            margin: 5px 0 10px 0;
            overflow: hidden;
        }
        .nav-item.active .submenu { display: block; animation: fadeIn 0.3s; }
        
        @keyframes fadeIn { from { opacity:0; transform:translateY(-5px); } to { opacity:1; transform:translateY(0); } }

        .submenu li a {
            display: block;
            padding: 10px 10px 10px 52px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13px;
            transition: 0.2s;
        }
        .submenu li a:hover { color: #fff; background: rgba(255,255,255,0.05); }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            padding: 15px 30px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 500;
        }

        .header-title h1 { font-size: 22px; font-weight: 700; }
        .header-title p { color: var(--text-muted); font-size: 13px; }
        .header-actions { display: flex; align-items: center; gap: 15px; }

        .icon-btn {
            width: 40px; height: 40px;
            border: 1px solid var(--glass-border);
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.3s;
            color: var(--text-primary);
        }
        .icon-btn:hover { background: var(--primary); color: white; }

        .user-profile {
            display: flex; align-items: center; gap: 10px;
            padding: 5px 10px;
            background: rgba(255,255,255,0.3);
            border-radius: 30px;
            cursor: pointer;
            border: 1px solid var(--glass-border);
        }
        .avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
        .user-info { font-size: 13px; }

        /* Stats Grid */
        .content { padding: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            padding: 20px;
            border-radius: 16px;
            box-shadow: var(--glass-shadow);
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        
        .stat-header { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .stat-icon { 
            width: 45px; height: 45px; 
            background: rgba(59, 130, 246, 0.1); color: var(--primary);
            border-radius: 12px; display: flex; align-items: center; justify-content: center; 
        }
        .stat-value { font-size: 28px; font-weight: 700; margin-bottom: 5px; }
        .stat-title { font-size: 14px; color: var(--text-muted); }

        /* Chart */
        .chart-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            padding: 25px;
            border-radius: 16px;
            box-shadow: var(--glass-shadow);
        }

        /* Responsive */
        .mobile-menu-btn { display: none; background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-primary); }
        
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-menu-btn { display: block; }
        }
        
        /* Dropdown */
        .dropdown-menu {
            position: absolute; top: 100%; right: 0; width: 200px;
            background: var(--glass-bg); backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border); border-radius: 10px;
            padding: 10px; display: none; z-index: 1000; margin-top: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .dropdown-menu.show { display: block; }
        .dropdown-item { display: block; padding: 10px; color: var(--text-primary); text-decoration: none; border-radius: 5px; font-size: 14px; }
        .dropdown-item:hover { background: rgba(0,0,0,0.05); color: var(--primary); }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="Paysure">
                <span>Paysure</span>
            </div>

            <ul class="nav-menu">
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span>Profile</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="edit-profile.php">Edit Profile</a></li>
                        <li><a href="kyc_details.php">Member KYC List</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        <span>Registration</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="registration.php">Member Joining</a></li>
                        <li><a href="franchise_registration.php">Franchise Joining</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11" /></svg>
                        <span>Genelogy</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="mydirect.php">My Direct</a></li>
                        <li><a href="team-summary.php">Team Summary</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Income</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="matching-bonus-details.php">Matching Bonus</a></li>
                        <li><a href="direct-sponsor-bonus.php">Sponsor Bonus</a></li>
                        <li><a href="Rank Income Details.php">Repurchase Bonus</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        <span>User Payment</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="user_pending_payments.php">Binary Pending Payment</a></li>
                        <li><a href="cappin_report.php">Cappin Report</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        <span>User</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="user_details.php">User Details</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        <span>My Referral Link</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <span>Report</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="tds_charge_details.php">TDS Report</a></li>
                        <li><a href="admin_charge_details.php">Admin Charge Report</a></li>
                        <li><a href="user_activation_history.php">User Activation Report</a></li>
                        <li><a href="user_paid_unpaid_report.php">PayOut Paid Report</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        <span>Downloads</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="kyc_details.php">File Download</a></li>
                        <li><a href="manage_offers.php">Monthly Offers</a></li>
                        <li><a href="manage_gallery.php">Gallery Section</a></li>
                        <li><a href="manage_training.php">Traning Schedule</a></li>
                        <li><a href="manage_welcome_letter.php">Welcome Letter</a></li>
                        <li><a href="admin_genealogy.php">GenealogyTree</a></li>
                        <li><a href="manage_graph.php">Graph</a></li>
                        <li><a href="manage_downloads.php">DownloadsSec</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                        <span>WebSites</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="kyc_details.php">Product Master</a></li>
                        <li><a href="kyc_details.php">About Banner</a></li>
                        <li><a href="kyc_details.php">Gallery Master</a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" onclick="toggleSubmenu(event)">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <span>Flash News</span>
                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <ul class="submenu">
                        <li><a href="kyc_details.php">PopUp Notice</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <span>Help Centre</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="main-content">
            <header class="header">
                <div style="display:flex; align-items:center; gap:15px;">
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="header-title">
                        <h1>Welcome Back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
                        <p>Here's what's happening with your store today.</p>
                    </div>
                </div>
                
                <div class="header-actions">
                    <button class="icon-btn" id="darkModeBtn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                    
                    <div style="position: relative;">
                        <div class="user-profile" id="userProfileBtn">
                             <?php
                                $profileImg = !empty($_SESSION['profile_image']) 
                                ? "uploads/profile/" . $_SESSION['profile_image'] 
                                : "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['full_name']);
                            ?>
                            <img src="<?php echo $profileImg; ?>" class="avatar">
                            <div class="user-info">
                                <b><?php echo explode(' ', $_SESSION['full_name'])[0]; ?></b>
                                <div style="color:var(--text-muted); font-size:11px;">Admin</div>
                            </div>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        <div class="dropdown-menu" id="profileDropdown">
                            <a href="edit-profile.php" class="dropdown-item">Edit Profile</a>
                            <a href="../admin/logout.php" class="dropdown-item" style="color:var(--danger);">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-title">Total Users</div>
                                <div class="stat-value">21,978</div>
                            </div>
                            <div class="stat-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                        </div>
                        <div style="font-size:13px; color:var(--success);">+18% from last month</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-title">Binary Income</div>
                                <div class="stat-value">$64,981</div>
                            </div>
                            <div class="stat-icon" style="color:#8b5cf6; background:rgba(139,92,246,0.1);">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <div style="font-size:13px; color:var(--success);">+12% from last month</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-title">Total Expenses</div>
                                <div class="stat-value">$18,158</div>
                            </div>
                            <div class="stat-icon" style="color:#ef4444; background:rgba(239,68,68,0.1);">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                            </div>
                        </div>
                        <div style="font-size:13px; color:var(--danger);">-2% from last month</div>
                    </div>
                </div>

            
            </div>
        </div>
    </div>

    <script>
        // Submenu Toggle
        function toggleSubmenu(e) {
            e.preventDefault();
            let parent = e.currentTarget.parentElement;
            parent.classList.toggle('active');
        }

        // Mobile Menu Toggle
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        // Dark Mode Toggle
        const darkBtn = document.getElementById('darkModeBtn');
        darkBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
        });
        
        // Profile Dropdown
        const profileBtn = document.getElementById('userProfileBtn');
        const profileMenu = document.getElementById('profileDropdown');
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        });
        window.addEventListener('click', () => {
            profileMenu.classList.remove('show');
        });

        // Chart
        const ctx = document.getElementById('mainChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Monthly Income',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 40000, 45000, 42000, 50000],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(0,0,0,0.05)' } }
                }
            }
        });
    </script>
</body>
</html>