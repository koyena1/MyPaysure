<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit;
}

require_once '../includes/db.php'; 
// Ensure $db is available
if (!isset($db)) {
    $database = new Database();
    $db = $database->getConnection();
}

$message = "";
$editCategory = "";
$editDescription = "";

// --- 1. HANDLE DELETE CLICK (NEW ADDITION) ---
if (isset($_GET['delete'])) {
    $delCat = $_GET['delete'];
    
    // Get file path to delete physical file
    $stmt = $db->prepare("SELECT file_path FROM downloads WHERE category = ?");
    $stmt->execute([$delCat]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // Delete physical file
        $filePath = "../" . $row['file_path'];
        if (file_exists($filePath)) { unlink($filePath); }
        
        // Delete DB Record
        $del = $db->prepare("DELETE FROM downloads WHERE category = ?");
        $del->execute([$delCat]);
        
        $message = "<div class='alert alert-danger'>File deleted successfully!</div>";
    }
}

// --- 2. HANDLE EDIT CLICK ---
if (isset($_GET['edit'])) {
    $editCategory = $_GET['edit'];
    // Fetch current details
    $stmt = $db->prepare("SELECT description FROM downloads WHERE category = ?");
    $stmt->execute([$editCategory]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $editDescription = $row['description'];
    }
}

// --- 3. HANDLE FORM SUBMIT (UPLOAD/UPDATE) ---
if (isset($_POST['save'])) {
    $category = $_POST['category'];
    $description = $_POST['description'];
    
    // Check if file is selected
    if (!empty($_FILES['file']['name'])) {
        $targetDir = "../uploads/resources/";
        if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
        
        $fileName = time() . "_" . basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $dbFilePath = "uploads/resources/" . $fileName;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Delete old file if exists
            $check = $db->prepare("SELECT file_path FROM downloads WHERE category = ?");
            $check->execute([$category]);
            $old = $check->fetch(PDO::FETCH_ASSOC);
            if ($old && file_exists("../" . $old['file_path'])) { unlink("../" . $old['file_path']); }

            // Delete old entry and insert new
            $db->prepare("DELETE FROM downloads WHERE category = ?")->execute([$category]);
            $stmt = $db->prepare("INSERT INTO downloads (title, category, description, file_path) VALUES (?, ?, ?, ?)");
            $stmt->execute([$category, $category, $description, $dbFilePath]);
            
            $message = "<div class='alert alert-success'>File updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Upload failed.</div>";
        }
    } else {
        // Just updating description
        $sql = "UPDATE downloads SET description = ? WHERE category = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$description, $category]);
        $message = "<div class='alert alert-success'>Description updated!</div>";
    }
    
    // Clear edit mode
    $editCategory = "";
    $editDescription = "";
}

// --- 4. FETCH CURRENT STATUS ---
$resources = [];
$stmt = $db->query("SELECT * FROM downloads");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resources[$row['category']] = $row;
}

$categories = ['Product Brochure', 'Application Form', 'Financial Guide'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Downloads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background:#f4f7f6; padding:30px; }</style>
</head>
<body>
<div class="container" style="max-width:900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manage Download Cards</h3>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php echo $message; ?>

    <?php if ($editCategory): ?>
    <div class="card p-4 shadow-sm mb-4 border-primary">
        <h5 class="text-primary">Editing: <?php echo $editCategory; ?></h5>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="category" value="<?php echo $editCategory; ?>">
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($editDescription); ?>" placeholder="e.g. Detailed product info">
            </div>

            <div class="mb-3">
                <label class="form-label">Upload New File (PDF/Doc)</label>
                <input type="file" name="file" class="form-control">
                <small class="text-muted">Leave empty to keep current file.</small>
            </div>

            <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
            <a href="manage_downloads.php" class="btn btn-light">Cancel</a>
        </form>
    </div>
    <?php endif; ?>

    <div class="card p-0 shadow-sm">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Card Name</th>
                    <th>Current File</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $cat): ?>
                <tr>
                    <td class="fw-bold"><?php echo $cat; ?></td>
                    <td>
                        <?php if(isset($resources[$cat])): ?>
                            <a href="../<?php echo $resources[$cat]['file_path']; ?>" target="_blank" class="text-success text-decoration-none">
                                <i class="fas fa-check-circle"></i> View File
                            </a>
                        <?php else: ?>
                            <span class="text-danger">No file uploaded</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo isset($resources[$cat]) ? date('d M Y', strtotime($resources[$cat]['uploaded_at'])) : '-'; ?>
                    </td>
                    <td>
                        <a href="?edit=<?php echo urlencode($cat); ?>" class="btn btn-sm btn-primary">Edit</a>
                        
                        <?php if(isset($resources[$cat])): ?>
                            <a href="?delete=<?php echo urlencode($cat); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>