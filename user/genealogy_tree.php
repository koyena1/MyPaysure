<?php
session_start();
// Ensure security checks
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit; 
}

// Database Connection
require_once '../includes/db.php'; 

$currentUser = $_SESSION['username'];

// --- FETCH CURRENT USER DETAILS (For Root Node Tooltip) ---
$rootStmt = $db->prepare("SELECT * FROM registrations WHERE member_code = ?");
$rootStmt->execute([$currentUser]);
$rootDetails = $rootStmt->fetch(PDO::FETCH_ASSOC);

// If not found in registrations (e.g. if username is different), try users table
if(!$rootDetails) {
    $userStmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $userStmt->execute([$currentUser]);
    $uData = $userStmt->fetch(PDO::FETCH_ASSOC);
    // Create a fallback array if registration data isn't found
    $rootDetails = [
        'full_name' => $uData['full_name'] ?? $currentUser,
        'member_code' => $currentUser,
        'mobile' => 'N/A',
        'email' => $uData['email'] ?? 'N/A'
    ];
}

// Fetch ID for Sponsor Code generation
$idStmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$idStmt->execute([$currentUser]);
$userIdData = $idStmt->fetch(PDO::FETCH_ASSOC);
$mySponsorCode = $userIdData ? 'SPON' . $userIdData['id'] : 'N/A';
// --------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Genealogy Tree</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .genealogy-body { min-height: 500px; padding: 30px 0; }
        .node-card {
            background: #fff; border-radius: 12px; padding: 20px;
            width: 100%; max-width: 250px; margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 4px solid #ccc; position: relative; z-index: 2;
            transition: transform 0.3s ease;
        }
        .node-card:hover { transform: translateY(-5px); }
        .node-card.root-node { border-color: #0d6efd; background: #f0f8ff; } /* Light blue bg for you */
        .node-card.active-node { border-color: #198754; }
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
        
        /* Sponsor Code Badge */
        .sponsor-badge {
            background: #0d6efd; color: white; padding: 4px 8px; 
            border-radius: 4px; font-size: 0.9rem; font-weight: bold;
            display: inline-block; margin-top: 5px;
        }

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
        
        /* Tooltip Style Fix */
        .tooltip-inner { text-align: left; max-width: 300px; }
    </style>
</head>
<body>

<div class="container genealogy-body">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">My Genealogy Tree</h2>
        <p class="text-muted">Direct Downline Structure</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <div class="node-card root-node"
                 data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                 title="<strong>Name:</strong> <?php echo htmlspecialchars($rootDetails['full_name']); ?><br><strong>ID:</strong> <?php echo htmlspecialchars($rootDetails['member_code']); ?><br><strong>Phone:</strong> <?php echo htmlspecialchars($rootDetails['mobile']); ?><br><strong>Email:</strong> <?php echo htmlspecialchars($rootDetails['email']); ?>">
                 
                <div class="user-icon"><i class="fas fa-user-circle"></i></div>
                <div class="node-name"><?php echo htmlspecialchars($currentUser); ?></div>
                
                <div class="mb-2">
                    <span class="sponsor-badge">Code: <?php echo htmlspecialchars($mySponsorCode); ?></span>
                </div>
                
                <div class="node-detail badge bg-secondary">You (Root)</div>
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
            // Fetch Left Leg (Added 'email' to SELECT)
            $stmt = $db->prepare("SELECT full_name, mobile, member_code, email FROM registrations WHERE sponsor_id = ? AND position = 'Left' LIMIT 1");
            $stmt->execute([$currentUser]);
            $left = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <div class="node-card <?php echo $left ? 'active-node' : 'empty-node'; ?>"
                 <?php if($left): ?>
                 data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                 title="<strong>Name:</strong> <?php echo htmlspecialchars($left['full_name']); ?><br><strong>ID:</strong> <?php echo htmlspecialchars($left['member_code']); ?><br><strong>Phone:</strong> <?php echo htmlspecialchars($left['mobile']); ?><br><strong>Email:</strong> <?php echo htmlspecialchars($left['email']); ?>"
                 <?php endif; ?>>
                 
                <div class="user-icon">
                    <i class="fas <?php echo $left ? 'fa-user' : 'fa-plus'; ?>"></i>
                </div>
                <?php if($left): ?>
                    <div class="node-name"><?php echo htmlspecialchars($left['full_name']); ?></div>
                    <div class="node-detail">
                        <i class="fas fa-id-badge me-1"></i> 
                        <?php echo htmlspecialchars($left['member_code'] ?? 'N/A'); ?>
                    </div>
                    <div class="badge bg-success mt-2">Left Leg</div>
                <?php else: ?>
                    <div class="node-name">Empty Slot</div>
                    <div class="node-detail">Available</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-6 col-md-4 text-center">
            <?php
            // Fetch Right Leg (Added 'email' to SELECT)
            $stmt = $db->prepare("SELECT full_name, mobile, member_code, email FROM registrations WHERE sponsor_id = ? AND position = 'Right' LIMIT 1");
            $stmt->execute([$currentUser]);
            $right = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <div class="node-card <?php echo $right ? 'active-node' : 'empty-node'; ?>"
                 <?php if($right): ?>
                 data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                 title="<strong>Name:</strong> <?php echo htmlspecialchars($right['full_name']); ?><br><strong>ID:</strong> <?php echo htmlspecialchars($right['member_code']); ?><br><strong>Phone:</strong> <?php echo htmlspecialchars($right['mobile']); ?><br><strong>Email:</strong> <?php echo htmlspecialchars($right['email']); ?>"
                 <?php endif; ?>>
                 
                <div class="user-icon">
                    <i class="fas <?php echo $right ? 'fa-user' : 'fa-plus'; ?>"></i>
                </div>
                <?php if($right): ?>
                    <div class="node-name"><?php echo htmlspecialchars($right['full_name']); ?></div>
                    <div class="node-detail">
                        <i class="fas fa-id-badge me-1"></i> 
                        <?php echo htmlspecialchars($right['member_code'] ?? 'N/A'); ?>
                    </div>
                    <div class="badge bg-success mt-2">Right Leg</div>
                <?php else: ?>
                    <div class="node-name">Empty Slot</div>
                    <div class="node-detail">Available</div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Bootstrap Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>