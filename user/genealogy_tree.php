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
// If admin or root wants to jump to a specific user
$view_id = isset($_GET['user']) ? $_GET['user'] : $current_user_id;

// --- RECURSIVE FUNCTION TO BUILD THE TREE ---
function buildTree($pdo, $parentId, $level = 0) {
    // Limit depth to prevent crashing on huge trees (e.g., show 5 levels at a time)
    if ($level > 5) {
        return '<li><a href="?user='.$parentId.'" class="load-more">Load More...</a></li>';
    }

    // Fetch the user details for this Node
    $stmt = $pdo->prepare("SELECT id, username, full_name, profile_image, my_spon_id FROM users WHERE id = ?");
    $stmt->execute([$parentId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) return "";

    // Image Handling
    $img = !empty($user['profile_image']) ? "../uploads/profile/".$user['profile_image'] : "../assets/images/logo.png";
    
    // HTML for the current Person (The Box)
    $html = '<li>';
    $html .= '<div class="member-view-box">
                <div class="member-image">
                    <img src="' . htmlspecialchars($img) . '" alt="Member">
                    <div class="member-details">
                        <h3>' . htmlspecialchars($user['full_name']) . '</h3>
                        <span>ID: ' . htmlspecialchars($user['username']) . '</span>
                    </div>
                </div>
              </div>';

    // Fetch Binary Children (Left & Right) from network_structure
    // We look for distributor_id where parent_id = current node
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
        
        // We need to ensure Left is displayed first, then Right.
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
            // Empty Left Slot
            $html .= '<li><div class="member-view-box empty-box"><span>Left Empty</span></div></li>';
        }

        // Render Right Leg
        if ($right_child) {
            $html .= buildTree($pdo, $right_child, $level + 1);
        } else {
            // Empty Right Slot (Only show if Left exists, or strictly binary appearance needed)
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
    <title>Genealogy Tree</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        
        /* Sidebar Styling (Same as dashboard) */
        .sidebar { width: 250px; background: #4b1f9b; color: white; padding: 20px; position: fixed; height: 100%; z-index: 1000; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; display: block; padding: 12px; margin: 5px 0; border-radius: 8px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #6a34e6; color: white; }
        .sidebar a i { margin-right: 10px; width: 20px; text-align: center; }
        
        .main-content { margin-left: 250px; padding: 20px; overflow: hidden; }

        /* --- GENEALOGY TREE CSS --- */
        .genealogy-scroll {
            width: 100%;
            height: 800px; /* Adjustable Height */
            overflow: auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 50px;
            text-align: center;
            white-space: nowrap; /* Keeps tree horizontal */
        }

        /* Tree Root */
        .genealogy-tree { display: inline-block; }
        .genealogy-tree ul {
            padding-top: 20px; position: relative;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
            display: flex; justify-content: center;
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
        }
        .member-view-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: #4b1f9b;
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

        /* Empty Slot Style */
        .empty-box {
            border: 2px dashed #ddd;
            background: #f9f9f9;
            opacity: 0.7;
        }
        .empty-box span { font-size: 12px; font-weight: bold; color: #999; }
        .load-more { font-size: 12px; font-weight: bold; color: #4b1f9b; text-decoration: none; }

        @media (max-width: 768px) {
            .sidebar { width: 60px; padding: 10px; }
            .sidebar span { display: none; }
            .main-content { margin-left: 60px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 class="text-center fw-bold mb-4 d-none d-md-block">PaySure</h3>
        <a href="client_dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        <a href="genealogy_tree.php" class="active"><i class="fas fa-sitemap"></i> <span>Binary Tree</span></a>
        <a href="my_directs.php"><i class="fas fa-users"></i> <span>My Directs</span></a>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-primary fw-bold">Genealogy Overview</h4>
            
            <form action="" method="GET" class="d-flex">
                <input type="text" name="user_search" placeholder="Enter ID to Search" class="form-control form-control-sm me-2">
                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                <a href="genealogy_tree.php" class="btn btn-sm btn-secondary ms-1">Reset</a>
            </form>
        </div>

        <div class="genealogy-scroll">
            <div class="genealogy-tree">
                <ul>
                    <?php 
                        // Start building from the selected User ID
                        // Note: We use the integer ID to build the tree relations
                        echo buildTree($pdo, $view_id); 
                    ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>