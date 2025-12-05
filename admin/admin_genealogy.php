<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['username'])) { 
    header("Location: ../login.php"); 
    exit; 
}

// 2. Database Connection
require_once '../includes/db.php'; 

$message = "";

// --- HANDLE FORM SUBMISSION: ADD MEMBER (WITH SPILLOVER) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_member') {
    $inputSponsorId = trim($_POST['sponsor_id']); // Must be a real Member Code (e.g., ADMIN01)
    $position  = $_POST['position']; 
    $fullName  = trim($_POST['full_name']);
    $mobile    = trim($_POST['mobile']);
    $email     = trim($_POST['email']);
    $password  = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    
    // Generate a unique Member Code
    $newMemberCode = 'MEM' . rand(10000, 99999);

    // 1. Validate if the Sponsor exists in REGISTRATIONS table
    $checkSpon = $db->prepare("SELECT member_code FROM registrations WHERE member_code = ?");
    $checkSpon->execute([$inputSponsorId]);
    
    if ($checkSpon->rowCount() === 0) {
        $message = "<div class='alert alert-danger'>
                        <i class='fas fa-exclamation-triangle'></i> <strong>Error:</strong> Sponsor ID '<strong>$inputSponsorId</strong>' not found.<br>
                        Please use a valid <strong>Member Code</strong> (e.g., 'ADMIN01'). Do not use 'SPON...' IDs.
                    </div>";
    } else {
        
        // 2. SPILLOVER LOGIC: Find the bottom of the chain
        $placementId = $inputSponsorId;
        
        while (true) {
            $checkLeg = $db->prepare("SELECT member_code FROM registrations WHERE sponsor_id = ? AND position = ?");
            $checkLeg->execute([$placementId, $position]);
            $existingMember = $checkLeg->fetch(PDO::FETCH_ASSOC);

            if ($existingMember) {
                // If spot is taken, jump down to THAT member
                $placementId = $existingMember['member_code'];
            } else {
                // Spot is empty! Break loop.
                break;
            }
        }

        // 3. Insert New Member
        try {
            $db->beginTransaction();

            // Insert into Registrations (Tree Structure)
            $sql = "INSERT INTO registrations (member_code, full_name, mobile, email, sponsor_id, position, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $db->prepare($sql);
            $stmt->execute([$newMemberCode, $fullName, $mobile, $email, $placementId, $position]);
            
            // Insert into Users (Login Access)
            // Check if username/email exists first to avoid duplicate error
            $checkUser = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $checkUser->execute([$newMemberCode, $email]);
            
            if($checkUser->rowCount() == 0) {
                $userSql = "INSERT INTO users (username, password_hash, email, full_name, role) VALUES (?, ?, ?, ?, 'user')";
                $userStmt = $db->prepare($userSql);
                $userStmt->execute([$newMemberCode, $password, $email, $fullName]);
            }

            $db->commit();

            $message = "<div class='alert alert-success'>
                            <i class='fas fa-check-circle'></i> <strong>Success!</strong> Member Added.<br>
                            <strong>New ID:</strong> $newMemberCode<br>
                            <strong>Placed Under:</strong> $placementId (Spillover from $inputSponsorId)
                        </div>";
        } catch (PDOException $e) {
            $db->rollBack();
            $message = "<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>";
        }
    }
}

// --- SEARCH LOGIC (SMARTER) ---
$search_input = isset($_GET['user']) ? trim($_GET['user']) : '';
$rootData = null;

if (!empty($search_input)) {
    // 1. Try finding by Member Code
    $stmt = $db->prepare("SELECT * FROM registrations WHERE member_code = ?");
    $stmt->execute([$search_input]);
    $rootData = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. If not found, try finding by Username (linking users table to registrations)
    if (!$rootData) {
        $uStmt = $db->prepare("SELECT username, email FROM users WHERE username = ? OR id = ?");
        $uStmt->execute([$search_input, $search_input]);
        $uData = $uStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($uData) {
            // Try lookup by Member Code = Username
            $stmt = $db->prepare("SELECT * FROM registrations WHERE member_code = ?");
            $stmt->execute([$uData['username']]);
            $rootData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // If still not found, try lookup by Email
            if (!$rootData) {
                 $stmt = $db->prepare("SELECT * FROM registrations WHERE email = ?");
                 $stmt->execute([$uData['email']]);
                 $rootData = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
} else {
    // Default: Load the very first user found in registrations (The Root Admin)
    $stmt = $db->query("SELECT * FROM registrations ORDER BY id ASC LIMIT 1");
    $rootData = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rootData) {
        $search_input = $rootData['member_code'];
    }
}

// Fetch Upline (Sponsor) Data
$uplineData = null;
if ($rootData && !empty($rootData['sponsor_id']) && $rootData['sponsor_id'] !== '0') {
    $upStmt = $db->prepare("SELECT * FROM registrations WHERE member_code = ?");
    $upStmt->execute([$rootData['sponsor_id']]);
    $uplineData = $upStmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Genealogy Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .main-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px;}
        
        /* Tree CSS */
        .genealogy-scroll { overflow-x: auto; padding-bottom: 50px; text-align: center; }
        .node-card {
            background: #fff; border-radius: 12px; padding: 15px;
            width: 220px; display: inline-block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid #ccc; position: relative; z-index: 2;
            transition: all 0.3s ease; cursor: pointer;
        }
        .node-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .node-card.root-node { border-color: #0d6efd; background: #f0f8ff; } 
        .node-card.active-node { border-color: #198754; }
        .node-card.empty-node { border-color: #6c757d; border-style: dashed; background: #f8f9fa; cursor: default;}
        
        .user-icon {
            width: 45px; height: 45px; background: #e9ecef; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px; font-size: 1.2rem; color: #495057;
        }
        .active-node .user-icon { background: #d1e7dd; color: #0f5132; }
        .root-node .user-icon { background: #cfe2ff; color: #084298; }
        .node-name { font-weight: 700; font-size: 1rem; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .node-detail { font-size: 0.8rem; color: #666; }

        .connector-vertical { width: 2px; background-color: #ccc; height: 30px; margin: 0 auto; }
        .tooltip-inner { max-width: 300px; text-align: left; padding: 10px; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary fw-bold"><i class="fas fa-sitemap me-2"></i> Genealogy Management</h3>
        <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>

    <?php if($message) echo $message; ?>

    <ul class="nav nav-tabs mb-3" id="genealogyTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="tree-tab" data-bs-toggle="tab" data-bs-target="#tree" type="button">Genealogy Tree</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button">Add Member</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="sponsor-tab" data-bs-toggle="tab" data-bs-target="#sponsor" type="button">Upline Info</button>
        </li>
    </ul>

    <div class="tab-content">
        
        <div class="tab-pane fade show active" id="tree">
            <div class="main-card">
                <form action="" method="GET" class="row g-2 justify-content-center mb-4">
                    <div class="col-auto">
                        <input type="text" name="user" class="form-control" placeholder="Search Member Code or Username" value="<?php echo htmlspecialchars($search_input); ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    <?php if($uplineData): ?>
                    <div class="col-auto">
                         <a href="?user=<?php echo $uplineData['member_code']; ?>" class="btn btn-outline-secondary" title="Go Up One Level"><i class="fas fa-arrow-up"></i> Up</a>
                    </div>
                    <?php endif; ?>
                </form>

                <div class="genealogy-scroll">
                    <?php if($rootData): ?>
                        
                        <div class="node-card root-node" 
                             data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                             title="<strong>Name:</strong> <?php echo htmlspecialchars($rootData['full_name']); ?><br><strong>ID:</strong> <?php echo htmlspecialchars($rootData['member_code']); ?><br><strong>Phone:</strong> <?php echo htmlspecialchars($rootData['mobile']); ?><br><strong>Email:</strong> <?php echo htmlspecialchars($rootData['email']); ?>">
                            <div class="user-icon"><i class="fas fa-user-circle"></i></div>
                            <div class="node-name"><?php echo htmlspecialchars($rootData['full_name']); ?></div>
                            <div class="node-detail"><?php echo htmlspecialchars($rootData['member_code']); ?></div>
                            <div class="badge bg-primary mt-1">ROOT</div>
                        </div>
                        <div class="connector-vertical"></div>
                        
                        <div class="row justify-content-center position-relative" style="max-width: 600px; margin: 0 auto;">
                            <div style="position: absolute; top: 0; left: 25%; width: 50%; height: 2px; background: #ccc;"></div>
                            <div style="position: absolute; top: 0; left: 25%; width: 2px; height: 20px; background: #ccc;"></div>
                            <div style="position: absolute; top: 0; right: 25%; width: 2px; height: 20px; background: #ccc;"></div>

                            <div class="col-6 text-center pt-3">
                                <?php
                                $lStmt = $db->prepare("SELECT * FROM registrations WHERE sponsor_id = ? AND position = 'Left'");
                                $lStmt->execute([$rootData['member_code']]);
                                $left = $lStmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if($left): ?>
                                    <a href="?user=<?php echo $left['member_code']; ?>" class="text-decoration-none text-dark">
                                        <div class="node-card active-node"
                                             data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                             title="<strong>Name:</strong> <?php echo htmlspecialchars($left['full_name']); ?><br><strong>ID:</strong> <?php echo htmlspecialchars($left['member_code']); ?><br><strong>Phone:</strong> <?php echo htmlspecialchars($left['mobile']); ?><br><strong>Email:</strong> <?php echo htmlspecialchars($left['email']); ?>">
                                            <div class="user-icon"><i class="fas fa-user"></i></div>
                                            <div class="node-name"><?php echo htmlspecialchars($left['full_name']); ?></div>
                                            <div class="node-detail"><?php echo htmlspecialchars($left['member_code']); ?></div>
                                            <div class="badge bg-success mt-1">Left</div>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <div class="node-card empty-node">
                                        <div class="user-icon"><i class="fas fa-plus"></i></div>
                                        <div class="node-name">Empty</div>
                                        <div class="node-detail">Available</div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-6 text-center pt-3">
                                <?php
                                $rStmt = $db->prepare("SELECT * FROM registrations WHERE sponsor_id = ? AND position = 'Right'");
                                $rStmt->execute([$rootData['member_code']]);
                                $right = $rStmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if($right): ?>
                                    <a href="?user=<?php echo $right['member_code']; ?>" class="text-decoration-none text-dark">
                                        <div class="node-card active-node"
                                             data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                             title="<strong>Name:</strong> <?php echo htmlspecialchars($right['full_name']); ?><br><strong>ID:</strong> <?php echo htmlspecialchars($right['member_code']); ?><br><strong>Phone:</strong> <?php echo htmlspecialchars($right['mobile']); ?><br><strong>Email:</strong> <?php echo htmlspecialchars($right['email']); ?>">
                                            <div class="user-icon"><i class="fas fa-user"></i></div>
                                            <div class="node-name"><?php echo htmlspecialchars($right['full_name']); ?></div>
                                            <div class="node-detail"><?php echo htmlspecialchars($right['member_code']); ?></div>
                                            <div class="badge bg-success mt-1">Right</div>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <div class="node-card empty-node">
                                        <div class="user-icon"><i class="fas fa-plus"></i></div>
                                        <div class="node-name">Empty</div>
                                        <div class="node-detail">Available</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-warning text-center p-4">
                            <h4><i class="fas fa-exclamation-triangle"></i> No Root User Found</h4>
                            <p>Please run the SQL command provided to create the initial Admin user in the <code>registrations</code> table.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="add">
            <div class="main-card">
                <h4 class="mb-4">Add New Member</h4>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <strong>Important:</strong> Enter the Sponsor's <strong>Member Code</strong> (e.g., <code>ADMIN01</code>). Do not use user IDs or "SPON" codes.
                </div>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" value="add_member">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sponsor Member Code</label>
                            <input type="text" name="sponsor_id" class="form-control" required placeholder="e.g. ADMIN01" value="<?php echo htmlspecialchars($search_input); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position (Leg)</label>
                            <select name="position" class="form-select" required>
                                <option value="Left">Left Leg</option>
                                <option value="Right">Right Leg</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-user-plus"></i> Register Member</button>
                </form>
            </div>
        </div>

        <div class="tab-pane fade" id="sponsor">
            <div class="main-card">
                <h4 class="mb-4">Upline Details (My Sponsor)</h4>
                <?php if($uplineData): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light">Sponsor Name</th>
                                    <td><?php echo htmlspecialchars($uplineData['full_name']); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Sponsor Code</th>
                                    <td><?php echo htmlspecialchars($uplineData['member_code']); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Mobile</th>
                                    <td><?php echo htmlspecialchars($uplineData['mobile']); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td><?php echo htmlspecialchars($uplineData['email']); ?></td>
                                </tr>
                            </table>
                            <a href="?user=<?php echo $uplineData['member_code']; ?>" class="btn btn-primary">View Sponsor's Tree</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary">
                        Top of the tree. This user (<?php echo htmlspecialchars($search_input); ?>) has no sponsor.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>