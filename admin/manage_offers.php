<?php
session_start();
require '../includes/db.php'; 

// 1. Check Admin Login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$message = "";
$message_type = "";
$edit_mode = false;
$edit_data = [];

// 2. CHECK IF EDIT MODE
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_data = $database->fetch("SELECT * FROM monthly_offers WHERE id = ?", [$edit_id]);
    if ($edit_data) {
        $edit_mode = true;
    }
}

// 3. HANDLE FORM SUBMISSIONS

// --- Helper Function for Image Upload ---
function handleImageUpload($fileInputName, $urlInputName, $currentImage = "") {
    $image_path = $currentImage; // Default to existing image

    // 1. Priority: File Upload
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES[$fileInputName]['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            $upload_dir = "../uploads/offers/";
            if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }
            
            $new_filename = uniqid('offer_') . '.' . $file_ext;
            $target_file = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $target_file)) {
                $image_path = "uploads/offers/" . $new_filename; 
            }
        }
    } 
    // 2. Secondary: URL Input (Only if not empty and different)
    elseif (!empty($_POST[$urlInputName])) {
        $image_path = trim($_POST[$urlInputName]);
    }
    
    // 3. Fallback (Only for new inserts)
    if (empty($image_path)) {
        $image_path = 'https://images.unsplash.com/photo-1554224154-2604c2c2591b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    }

    return $image_path;
}

// A. UPDATE EXISTING OFFER
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_offer'])) {
    $id = $_POST['offer_id'];
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    
    // Handle Image (Pass current image to keep it if no new one provided)
    $image = handleImageUpload('offer_image', 'image_url', $_POST['current_image']);

    // Other Fields
    $validity = trim($_POST['offer_validity']);
    $badge = trim($_POST['badge_text']);
    $benefits = trim($_POST['key_benefits']);
    $invest_det = trim($_POST['investment_details']);
    $loan_det = trim($_POST['loan_details']);
    $ins_det = trim($_POST['insurance_details']);
    $terms = trim($_POST['terms_conditions']);
    $support = trim($_POST['contact_support']);
    $email = trim($_POST['contact_email']);
    $phone = trim($_POST['contact_phone']);
    $website = trim($_POST['contact_website']);
    $branches = trim($_POST['branch_locations']);

    if (!empty($title) && !empty($desc)) {
        $sql = "UPDATE monthly_offers SET 
                title=?, offer_validity=?, badge_text=?, image_url=?, 
                description=?, key_benefits=?, 
                investment_details=?, loan_details=?, insurance_details=?, 
                terms_conditions=?, contact_support=?, contact_email=?, contact_phone=?, contact_website=?, branch_locations=?
                WHERE id=?";
        
        $params = [
            $title, $validity, $badge, $image, 
            $desc, $benefits, 
            $invest_det, $loan_det, $ins_det, 
            $terms, $support, $email, $phone, $website, $branches, 
            $id
        ];

        if($database->query($sql, $params)) {
            header("Location: manage_offers.php?msg=updated");
            exit;
        } else {
            $message = "Failed to update offer."; $message_type = "error";
        }
    } else {
        $message = "Title and Summary are required."; $message_type = "error";
    }
}

// B. ADD NEW OFFER
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_offer'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $image = handleImageUpload('offer_image', 'image_url');

    // Other Fields
    $validity = trim($_POST['offer_validity']);
    $badge = trim($_POST['badge_text']);
    $benefits = trim($_POST['key_benefits']);
    $invest_det = trim($_POST['investment_details']);
    $loan_det = trim($_POST['loan_details']);
    $ins_det = trim($_POST['insurance_details']);
    $terms = trim($_POST['terms_conditions']);
    $support = trim($_POST['contact_support']);
    $email = trim($_POST['contact_email']);
    $phone = trim($_POST['contact_phone']);
    $website = trim($_POST['contact_website']);
    $branches = trim($_POST['branch_locations']);

    if (!empty($title) && !empty($desc)) {
        $sql = "INSERT INTO monthly_offers (
            title, offer_validity, badge_text, image_url, 
            description, key_benefits, 
            investment_details, loan_details, insurance_details, 
            terms_conditions, contact_support, contact_email, contact_phone, contact_website, branch_locations,
            is_active
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        
        $params = [
            $title, $validity, $badge, $image, 
            $desc, $benefits, 
            $invest_det, $loan_det, $ins_det, 
            $terms, $support, $email, $phone, $website, $branches
        ];
        
        if($database->query($sql, $params)) {
            $message = "Offer added successfully!"; $message_type = "success";
        } else {
            $message = "Failed to add offer."; $message_type = "error";
        }
    } else {
        $message = "Title and Summary are required."; $message_type = "error";
    }
}

// C. DELETE & TOGGLE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Optional: Delete image file logic here if needed
    $database->query("DELETE FROM monthly_offers WHERE id = ?", [$id]);
    header("Location: manage_offers.php?msg=deleted"); exit;
}

if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $curr = $database->fetch("SELECT is_active FROM monthly_offers WHERE id = ?", [$id]);
    if($curr) {
        $new_status = ($curr['is_active'] == 1) ? 0 : 1;
        $database->query("UPDATE monthly_offers SET is_active = ? WHERE id = ?", [$new_status, $id]);
        header("Location: manage_offers.php?msg=status_changed"); exit;
    }
}

// 4. Fetch All Offers
$offers = $database->fetchAll("SELECT * FROM monthly_offers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers - Paysure Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Shared Styles */
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
            --warning: #f59e0b;
        }
        body { font-family: 'Inter', sans-serif; color: var(--text-primary); background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); background-attachment: fixed; min-height: 100vh; }
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 280px; background: var(--sidebar-glass); backdrop-filter: blur(16px); border-right: 1px solid rgba(255,255,255,0.1); color: white; padding: 20px 10px; position: fixed; height: 100vh; overflow-y: auto; z-index: 1000; }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        .logo { display: flex; align-items: center; gap: 12px; padding: 0 15px 25px 15px; font-size: 20px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .logo img { width: 40px; height: 40px; object-fit: contain; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 12px; transition: all 0.3s ease; font-size: 14px; font-weight: 500; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { background: rgba(255, 255, 255, 0.15); color: white; }

        /* Content */
        .main-content { flex: 1; margin-left: 280px; padding: 30px; }
        .card { background: var(--glass-bg); backdrop-filter: blur(12px); border: 1px solid var(--glass-border); border-radius: 16px; box-shadow: var(--glass-shadow); padding: 25px; margin-bottom: 30px; }
        .card h2 { margin-bottom: 20px; color: var(--primary); font-size: 1.5rem; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 10px; }
        
        .form-section-title { font-size: 1.1rem; font-weight: 600; color: #4b5563; margin: 20px 0 15px 0; display: block; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-full { grid-column: 1 / -1; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 12px; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; background: rgba(255,255,255,0.5); font-family: inherit; outline: none; transition: 0.3s; }
        .form-control:focus { border-color: var(--primary); background: white; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        
        /* File Input */
        input[type="file"] { padding: 10px; background: white; border-radius: 8px; border: 1px solid #ccc; width: 100%; cursor: pointer; }

        .btn { padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-primary { background: var(--primary); color: white; width: 100%; margin-top: 10px; }
        .btn-warning { background: var(--warning); color: white; width: 100%; margin-top: 10px; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-sm { padding: 6px 12px; font-size: 0.85rem; border-radius: 6px; text-decoration: none; display: inline-block;}
        .btn-edit { background: rgba(59,130,246,0.1); color: var(--primary); }
        .btn-danger { background: rgba(239,68,68,0.1); color: var(--danger); }

        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }

        @media (max-width: 768px) { .sidebar { display: none; } .main-content { margin-left: 0; } .form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="Paysure">
                <span>Paysure Admin</span>
            </div>
            <nav>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="manage_offers.php" class="nav-link active" style="background: rgba(255,255,255,0.15);">Manage Offers</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </nav>
        </aside>

        <div class="main-content">
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success">Operation successful.</div>
            <?php endif; ?>

            <div class="card" id="offerForm">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2><?php echo $edit_mode ? 'Edit Monthly Offer' : 'Add New Monthly Offer'; ?></h2>
                    <?php if($edit_mode): ?>
                        <a href="manage_offers.php" class="btn-sm btn-danger">Cancel Edit</a>
                    <?php endif; ?>
                </div>

                <form method="POST" action="manage_offers.php" enctype="multipart/form-data">
                    
                    <?php if($edit_mode): ?>
                        <input type="hidden" name="offer_id" value="<?php echo $edit_data['id']; ?>">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($edit_data['image_url']); ?>">
                    <?php endif; ?>

                    <span class="form-section-title">1. Basic Information</span>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Offer Title *</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['title']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Offer Validity</label>
                            <input type="text" name="offer_validity" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['offer_validity']) : ''; ?>" placeholder="e.g. Valid till 31st Dec">
                        </div>
                        <div class="form-group">
                            <label>Badge Text</label>
                            <input type="text" name="badge_text" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['badge_text']) : ''; ?>" placeholder="e.g. Best Seller">
                        </div>
                        
                        <div class="form-group">
                            <label>Offer Image (Upload)</label>
                            <input type="file" name="offer_image" class="form-control" accept="image/*">
                            <?php if($edit_mode && !empty($edit_data['image_url'])): ?>
                                <small>Current: <a href="../<?php echo $edit_data['image_url']; ?>" target="_blank">View Image</a></small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>OR Image URL</label>
                            <input type="text" name="image_url" class="form-control" value="<?php echo $edit_mode && strpos($edit_data['image_url'], 'http') === 0 ? htmlspecialchars($edit_data['image_url']) : ''; ?>" placeholder="https://...">
                        </div>
                        <div class="form-group"></div> <div class="form-group form-full">
                            <label>Offer Summary *</label>
                            <textarea name="description" class="form-control" rows="2" required><?php echo $edit_mode ? htmlspecialchars($edit_data['description']) : ''; ?></textarea>
                        </div>
                        <div class="form-group form-full">
                            <label>Key Benefits</label>
                            <textarea name="key_benefits" class="form-control" rows="3"><?php echo $edit_mode ? htmlspecialchars($edit_data['key_benefits']) : ''; ?></textarea>
                        </div>
                    </div>

                    <span class="form-section-title">2. Detailed Offer Breakdown</span>
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label>A. Investment Products Details</label>
                            <textarea name="investment_details" class="form-control" rows="2"><?php echo $edit_mode ? htmlspecialchars($edit_data['investment_details']) : ''; ?></textarea>
                        </div>
                        <div class="form-group form-full">
                            <label>B. Loan Products Details</label>
                            <textarea name="loan_details" class="form-control" rows="2"><?php echo $edit_mode ? htmlspecialchars($edit_data['loan_details']) : ''; ?></textarea>
                        </div>
                        <div class="form-group form-full">
                            <label>C. Insurance Plans Details</label>
                            <textarea name="insurance_details" class="form-control" rows="2"><?php echo $edit_mode ? htmlspecialchars($edit_data['insurance_details']) : ''; ?></textarea>
                        </div>
                    </div>

                    <span class="form-section-title">3. Terms & Contact Information</span>
                    <div class="form-grid">
                        <div class="form-group form-full">
                            <label>Terms & Conditions</label>
                            <textarea name="terms_conditions" class="form-control" rows="2"><?php echo $edit_mode ? htmlspecialchars($edit_data['terms_conditions']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Customer Support Name</label>
                            <input type="text" name="contact_support" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['contact_support']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>Support Email</label>
                            <input type="email" name="contact_email" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['contact_email']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>Support Phone</label>
                            <input type="text" name="contact_phone" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['contact_phone']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>Website URL</label>
                            <input type="text" name="contact_website" class="form-control" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['contact_website']) : ''; ?>">
                        </div>
                        <div class="form-group form-full">
                            <label>Branch Locations</label>
                            <textarea name="branch_locations" class="form-control" rows="2"><?php echo $edit_mode ? htmlspecialchars($edit_data['branch_locations']) : ''; ?></textarea>
                        </div>
                    </div>

                    <?php if($edit_mode): ?>
                        <button type="submit" name="update_offer" class="btn btn-warning">Update Offer Details</button>
                    <?php else: ?>
                        <button type="submit" name="add_offer" class="btn btn-primary">Publish New Offer</button>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <h2>Active Offers List</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($offers): ?>
                                <?php foreach ($offers as $offer): ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo (strpos($offer['image_url'], 'http') === 0) ? $offer['image_url'] : '../'.$offer['image_url']; ?>" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($offer['title']); ?></strong>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($offer['offer_validity']); ?>
                                        </td>
                                        <td>
                                            <?php if($offer['is_active']): ?>
                                                <span class="badge badge-active">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-inactive">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="manage_offers.php?edit=<?php echo $offer['id']; ?>#offerForm" class="btn-sm btn-edit" style="margin-right:5px;">Edit</a>
                                            
                                            <a href="manage_offers.php?toggle=<?php echo $offer['id']; ?>" class="btn-sm" style="background: #f3f4f6; color: #333; margin-right: 5px;">
                                               <?php echo $offer['is_active'] ? 'Disable' : 'Enable'; ?>
                                            </a>
                                            
                                            <a href="manage_offers.php?delete=<?php echo $offer['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('Delete this offer?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" style="text-align:center;">No offers found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>