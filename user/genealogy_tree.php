<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit;
}

// 2. Database Connection
require_once '../includes/db.php';

// Ensure $pdo is available
if (!isset($pdo) && isset($db)) { $pdo = $db; }

// 3. Logic: Whose tree to view?
$current_user_id = $_SESSION['user_id'];
$view_id = isset($_GET['user']) ? $_GET['user'] : $current_user_id;

// --- RECURSIVE FUNCTION TO BUILD THE TREE ---
function buildTree($pdo, $parentId, $level = 0) {
    // Limit depth to prevent crashing on huge trees
    if ($level > 5) {
        return '<li><a href="?user='.$parentId.'" class="load-more">Load More...</a></li>';
    }

    // Fetch the user details for this Node
    // ADDED: member_code to the query
    $stmt = $pdo->prepare("SELECT id, username, member_code, full_name, profile_image, my_spon_id, email, mobile FROM users WHERE id = ?");
    $stmt->execute([$parentId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) return "";

    // --- LOGIC: DISPLAY ID ---
    // If a Member Code exists (e.g., 847291), show that. Otherwise show Username.
    $display_id = !empty($user['member_code']) ? $user['member_code'] : $user['username'];

    // --- LOGIC: IMAGE HANDLING (FIXED PATH) ---
    // Your images are in 'user/uploads/profile', and this file is in 'user/'.
    // So the correct relative path is 'uploads/profile/', NOT '../uploads/profile/'
    $profile_path_check = "uploads/profile/" . $user['profile_image'];
    
    // Check if image exists in folder AND is not empty in DB
    if (!empty($user['profile_image']) && file_exists($profile_path_check)) {
        $img = $profile_path_check;
    } else {
        // Fallback: Generate a nice Avatar with initials (No PaySure Logo)
        $img = "https://ui-avatars.com/api/?name=" . urlencode($user['full_name']) . "&background=random&color=fff&size=128";
    }
    
    // HTML for the current Person (The Box)
    $html = '<li>';
    $html .= '<div class="member-view-box">
                <div class="member-image">
                    <img src="' . htmlspecialchars($img) . '" alt="Member">
                    <div class="member-details">
                        <h3>' . htmlspecialchars($user['full_name']) . '</h3>
                        <span>ID: ' . htmlspecialchars($display_id) . '</span>
                    </div>
                </div>

                <div class="hover-card">
                    <img src="' . htmlspecialchars($img) . '" class="hover-profile-img" alt="Profile">
                    <h4 class="hover-name">' . htmlspecialchars($user['full_name']) . '</h4>
                    <span class="hover-id">ID: ' . htmlspecialchars($display_id) . '</span>
                    <hr>
                    <div class="hover-info">
                        <p><i class="fas fa-envelope"></i> ' . htmlspecialchars($user['email']) . '</p>
                        <p><i class="fas fa-phone"></i> ' . htmlspecialchars($user['mobile']) . '</p>
                    </div>
                </div>
              </div>';

    // Fetch Binary Children
    $childStmt = $pdo->prepare("
        SELECT ns.distributor_id, ns.leg_type 
        FROM network_structure ns 
        WHERE ns.parent_id = ? 
        ORDER BY ns.leg_type ASC
    ");
    $childStmt->execute([$parentId]);
    $children = $childStmt->fetchAll(PDO::FETCH_ASSOC);

    // If there are children, start a nested list
    if ($children) {
        $html .= '<ul>';
        
        $left_child = null;
        $right_child = null;

        foreach($children as $child) {
            if($child['leg_type'] == 'Left') $left_child = $child['distributor_id'];
            if($child['leg_type'] == 'Right') $right_child = $child['distributor_id'];
        }

        // Render Left Leg
        if ($left_child) {
            $html .= buildTree($pdo, $left_child, $level + 1);
        } else {
            $html .= '<li><div class="member-view-box empty-box"><span>Left Empty</span></div></li>';
        }

        // Render Right Leg
        if ($right_child) {
            $html .= buildTree($pdo, $right_child, $level + 1);
        } else {
             $html .= '<li><div class="member-view-box empty-box"><span>Right Empty</span></div></li>';
        }

        $html .= '</ul>';
    }

    $html .= '</li>';
    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Genealogy Tree</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar { width: 250px; background: #4b1f9b; color: white; padding: 20px; position: fixed; height: 100%; z-index: 1000; transition: all 0.3s; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; padding: 12px; margin: 5px 0; border-radius: 8px; transition: 0.3s; display: flex; align-items: center; }
        .sidebar a:hover, .sidebar a.active { background: #6a34e6; color: white; }
        .sidebar a i { margin-right: 10px; width: 20px; text-align: center; }
        
        .main-content { margin-left: 250px; padding: 20px; transition: all 0.3s; min-height: 100vh; }

        /* --- GENEALOGY TREE CSS --- */
        .genealogy-scroll {
            width: 100%;
            height: calc(100vh - 150px);
            min-height: 500px;
            overflow: auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 50px;
            text-align: center;
            white-space: nowrap; 
            scrollbar-width: thin;
            scrollbar-color: #4b1f9b #f0f0f0;
        }

        /* Tree Root */
        .genealogy-tree { display: inline-block; padding-bottom: 50px; }
        .genealogy-tree ul {
            padding-top: 20px; position: relative;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
            display: flex; justify-content: center;
            padding-left: 0;
        }

        .genealogy-tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /* Connectors */
        .genealogy-tree li::before, .genealogy-tree li::after {
            content: ''; position: absolute; top: 0; right: 50%;
            border-top: 2px solid #ccc; width: 50%; height: 20px;
        }
        .genealogy-tree li::after { right: auto; left: 50%; border-left: 2px solid #ccc; }

        .genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before { display: none; }
        .genealogy-tree li:only-child { padding-top: 0; }
        .genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after { border: 0 none; }
        
        .genealogy-tree li:last-child::before { border-right: 2px solid #ccc; border-radius: 0 5px 0 0; }
        .genealogy-tree li:first-child::after { border-radius: 5px 0 0 0; }

        .genealogy-tree ul ul::before {
            content: ''; position: absolute; top: 0; left: 50%;
            border-left: 2px solid #ccc; width: 0; height: 20px;
        }

        /* Member Box Style */
        .member-view-box {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
            display: inline-block;
            min-width: 150px;
            position: relative;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            overflow: visible; 
            cursor: pointer;
        }
        
        .member-view-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: #4b1f9b;
            z-index: 100;
        }

        .member-image { text-align: center; }
        .member-image img {
            width: 60px; height: 60px;
            border-radius: 50%;
            border: 3px solid #eee;
            margin-bottom: 5px;
            object-fit: cover;
        }
        .member-details h3 { font-size: 14px; font-weight: 700; margin: 0; color: #333; }
        .member-details span { font-size: 12px; color: #777; }

        /* --- HOVER CARD STYLING --- */
        .hover-card {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            background: white;
            border: 2px solid #4b1f9b;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            z-index: 999;
            text-align: center;
        }

        .member-view-box:hover .hover-card {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        .hover-profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #4b1f9b;
            margin-bottom: 10px;
            object-fit: cover;
        }
        
        .hover-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        
        .hover-id {
            font-size: 13px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }
        
        .hover-card hr { margin: 10px 0; border-top: 1px solid #eee; }
        
        .hover-info p {
            margin: 5px 0;
            font-size: 13px;
            color: #555;
            text-align: left;
            word-break: break-all;
        }
        
        .hover-info i {
            color: #4b1f9b;
            width: 20px;
            text-align: center;
            margin-right: 5px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -40%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        /* Empty Slot Style */
        .empty-box {
            border: 2px dashed #ddd;
            background: #f9f9f9;
            opacity: 0.7;
            cursor: default;
        }
        .empty-box:hover {
            transform: none;
            box-shadow: none;
            border-color: #ddd;
        }
        .empty-box span { font-size: 12px; font-weight: bold; color: #999; }
        .load-more { font-size: 12px; font-weight: bold; color: #4b1f9b; text-decoration: none; }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 768px) {
            .sidebar { width: 70px; padding: 15px 10px; }
            .sidebar span, .sidebar h3 { display: none; }
            .sidebar a i { margin-right: 0; font-size: 1.2rem; }
            .sidebar a { justify-content: center; }
            .main-content { margin-left: 70px; padding: 15px; }
            .genealogy-scroll { padding: 20px; }

            .member-view-box { min-width: 100px; padding: 8px 10px; }
            .member-image img { width: 45px; height: 45px; }
            .member-details h3 { font-size: 12px; }
            .member-details span { font-size: 10px; }
            .genealogy-tree li { padding: 20px 2px 0 2px; }
            .hover-card { width: 220px; }
        }

        @media (max-width: 480px) {
            .header-controls { flex-direction: column; align-items: flex-start; gap: 10px; }
            .header-controls form { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 class="text-center fw-bold mb-4">PaySure</h3>
        <a href="client_dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        <a href="genealogy_tree.php" class="active"><i class="fas fa-sitemap"></i> <span>Genealogy Tree</span></a>
        <a href="my_directs.php"><i class="fas fa-users"></i> <span>My Directs</span></a>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
    </div>

    <div class="main-content">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 header-controls">
            <h4 class="text-primary fw-bold">Genealogy Overview</h4>
            
            <form action="" method="GET" class="d-flex">
                <input type="text" name="user_search" placeholder="Enter ID to Search" class="form-control form-control-sm me-2">
                <button type="submit" class="btn btn-sm btn-primary text-nowrap">Search</button>
                <a href="genealogy_tree.php" class="btn btn-sm btn-secondary ms-1">Reset</a>
            </form>
        </div>

        <div class="genealogy-scroll">
            <div class="genealogy-tree">
                <ul>
                    <?php 
                        // Start building from the selected User ID
                        echo buildTree($pdo, $view_id); 
                    ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>