<?php
session_start();

// 1. Security: Check if Admin is logged in
// Adjust this check based on your specific admin login session variable
if (!isset($_SESSION['username'])) { 
    header("Location: ../login.php"); 
    exit; 
}

// Optional: specific role check if you have roles stored in session
// if ($_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; }

// 2. Database Connection
require_once '../includes/db.php'; 

// 3. Determine which User's Tree to view
// Default to the logged-in admin or a specific user from search
$search_user = isset($_GET['user']) ? trim($_GET['user']) : $_SESSION['username'];

// Fetch Root User Data (The person at the top of this view)
// We verify if this user exists in the 'users' table or 'registrations' to get their details
$rootUserStmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$rootUserStmt->execute([$search_user]);
$rootUserData = $rootUserStmt->fetch(PDO::FETCH_ASSOC);

// If not found in users table, try looking up by member_code in registrations 
// (In case admin searches by Member Code instead of Username)
if (!$rootUserData) {
    $regStmt = $db->prepare("SELECT * FROM registrations WHERE member_code = ?");
    $regStmt->execute([$search_user]);
    $regData = $regStmt->fetch(PDO::FETCH_ASSOC);
    
    // If we found them in registrations, we use that info, 
    // but the tree logic relies on 'sponsor_id' matching this ID.
    if ($regData) {
        $search_user = $regData['member_code']; // normalized
        $displayName = $regData['full_name'];
        $displayCode = $regData['member_code'];
    } else {
        $displayName = "User Not Found";
        $displayCode = "N/A";
    }
} else {
    $displayName = $rootUserData['full_name'];
    $displayCode = "ID: " . $rootUserData['id']; // Or username
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Genealogy - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .genealogy-body { min-height: 500px; padding: 30px 0; }
        
        /* Admin specific header styles */
        .admin-controls {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .node-card {
            background: #fff; border-radius: 12px; padding: 20px;
            width: 100%; max-width: 250px; margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid #ccc; position: relative; z-index: 2;
            transition: transform 0.3s ease;
        }
        .node-card:hover { transform: translateY(-5px); }
        .node-card.root-node { border-color: #0d6efd; background: #f0f8ff; } 
        .node-card.active-node { border-color: #198754; cursor: pointer; }
        .node-card.empty-node { border-color: #6c757d; border-style: dashed; background: #f8f9fa;}
        
        .user-icon {
            width: 50px; height: 50px; background: #e9ecef; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px; font-size: 1.5rem; color: #495057;
        }
        .active-node .user-icon { background: #d1e7dd; color: #0f5132; }
        .root-node .user-icon { background: #cfe2ff; color: #084298; }
        .node-name { font-weight: 700; font-size: 1.1rem; color: #333; margin-bottom: 5px; }
        .node-detail { font-size: 0.85rem; color: #666; }
        
        /* Connectors */
        .tree-connector { position: relative; padding-top: 20px; }
        .connector-vertical { width: 2px; background-color: #ccc; height: 30px; margin: 0 auto; }
        .connector-horizontal {
            width: 50%; height: 2px; background-color: #ccc; margin: 0 auto;
            position: relative; top: -1px;
        }
        .connector-horizontal::before, .connector-horizontal::after {
            content: ''; position: absolute; top: 0; height: 20px; width: 2px; background-color: #ccc;
        }
        .connector-horizontal::before { left: 0; }
        .connector-horizontal::after { right: 0; }
    </style>
</head>
<body>

<div class="container genealogy-body">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="admin-controls text-center">
                <h4 class="mb-3">Admin Genealogy Viewer</h4>
                <form action="" method="GET" class="d-flex gap-2 justify-content-center">
                    <input type="text" name="user" class="form-control w-50" placeholder="Enter Username or Member Code" value="<?php echo htmlspecialchars($search_user); ?>" required>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search Tree</button>
                    <a href="manage_genealogy.php" class="btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <div class="node-card root-node">
                <div class="user-icon"><i class="fas fa-user-shield"></i></div>
                <div class="node-name"><?php echo htmlspecialchars($search_user); ?></div>
                <div class="node-detail"><?php echo htmlspecialchars($displayName); ?></div>
                <div class="node-detail badge bg-primary mt-1"><?php echo htmlspecialchars($displayCode); ?></div>
            </div>
            <div class="connector-vertical"></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="connector-horizontal"></div>
        </div>
    </div>

    <div class="row justify-content-center pt-3">
        
        <div class="col-6 col-md-4 text-center">
            <?php
            // Logic: Find registration where sponsor_id matches the Searched User AND position is Left
            $stmt = $db->prepare("SELECT full_name, mobile, member_code, email FROM registrations WHERE sponsor_id = ? AND position = 'Left' LIMIT 1");
            $stmt->execute([$search_user]);
            $left = $stmt->fetch(PDO::FETCH_ASSOC);

            // Try to find the username associated with this member to allow clicking deeper
            // Note: This relies on email matching in users table, or we pass member_code if your system uses that for login
            $leftLink = '#';
            if ($left) {
                 // Try to find username in users table using email to allow traversal
                 $uStmt = $db->prepare("SELECT username FROM users WHERE email = ?");
                 $uStmt->execute([$left['email']]);
                 $uData = $uStmt->fetch();
                 // If found in users, link to username, else link to member_code (fallback)
                 $nextUser = $uData ? $uData['username'] : ($left['member_code'] ?? '');
                 if($nextUser) {
                    $leftLink = "?user=" . urlencode($nextUser);
                 }
            }
            ?>

            <?php if($left): ?>
                <a href="<?php echo $leftLink; ?>" class="text-decoration-none">
                    <div class="node-card active-node" title="Click to view this user's tree">
                        <div class="user-icon"><i class="fas fa-user"></i></div>
                        <div class="node-name"><?php echo htmlspecialchars($left['full_name']); ?></div>
                        <div class="node-detail">
                            <i class="fas fa-id-badge me-1"></i> 
                            <?php echo htmlspecialchars($left['member_code'] ?? 'N/A'); ?>
                        </div>
                        <div class="badge bg-success mt-2">Left Leg</div>
                        <div class="mt-2 text-muted small"><i class="fas fa-level-down-alt"></i> Click to Expand</div>
                    </div>
                </a>
            <?php else: ?>
                <div class="node-card empty-node">
                    <div class="user-icon"><i class="fas fa-plus"></i></div>
                    <div class="node-name">Empty Slot</div>
                    <div class="node-detail">Available</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-6 col-md-4 text-center">
            <?php
            // Logic: Find registration where sponsor_id matches the Searched User AND position is Right
            $stmt = $db->prepare("SELECT full_name, mobile, member_code, email FROM registrations WHERE sponsor_id = ? AND position = 'Right' LIMIT 1");
            $stmt->execute([$search_user]);
            $right = $stmt->fetch(PDO::FETCH_ASSOC);

            // Determine Link for traversal
            $rightLink = '#';
            if ($right) {
                 $uStmt = $db->prepare("SELECT username FROM users WHERE email = ?");
                 $uStmt->execute([$right['email']]);
                 $uData = $uStmt->fetch();
                 $nextUser = $uData ? $uData['username'] : ($right['member_code'] ?? '');
                 if($nextUser) {
                    $rightLink = "?user=" . urlencode($nextUser);
                 }
            }
            ?>

            <?php if($right): ?>
                <a href="<?php echo $rightLink; ?>" class="text-decoration-none">
                    <div class="node-card active-node" title="Click to view this user's tree">
                        <div class="user-icon"><i class="fas fa-user"></i></div>
                        <div class="node-name"><?php echo htmlspecialchars($right['full_name']); ?></div>
                        <div class="node-detail">
                            <i class="fas fa-id-badge me-1"></i> 
                            <?php echo htmlspecialchars($right['member_code'] ?? 'N/A'); ?>
                        </div>
                        <div class="badge bg-success mt-2">Right Leg</div>
                        <div class="mt-2 text-muted small"><i class="fas fa-level-down-alt"></i> Click to Expand</div>
                    </div>
                </a>
            <?php else: ?>
                <div class="node-card empty-node">
                    <div class="user-icon"><i class="fas fa-plus"></i></div>
                    <div class="node-name">Empty Slot</div>
                    <div class="node-detail">Available</div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>