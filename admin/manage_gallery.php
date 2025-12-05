<?php
session_start();
// Since this file is in 'admin', we go up one level to find includes
require_once '../includes/db.php';

$database = new Database();
$db = $database->getConnection();

// --- IMAGE UPLOAD FUNCTION ---
function uploadImage($file, $type) {
    if (!empty($file['name'])) {
        // We save inside the current folder's 'uploads' directory (admin/uploads)
        $target_dir = "uploads/" . $type . "/";
        
        // This is the path we save in the database
        $db_path_prefix = "uploads/" . $type . "/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $filename = time() . '_' . basename($file['name']);
        $target_file = $target_dir . $filename; 
        
        $check = getimagesize($file['tmp_name']);
        if($check !== false) {
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                return $db_path_prefix . $filename;
            }
        }
    }
    return false;
}

// --- DELETE ITEM ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    
    if ($row) {
        // Delete file from local uploads folder
        if (!empty($row['image_path']) && file_exists($row['image_path'])) {
            unlink($row['image_path']);
        }
        $del = $db->prepare("DELETE FROM gallery WHERE id = ?");
        $del->execute([$id]);
    }
    header("Location: manage_gallery.php");
    exit();
}

// --- SAVE / UPDATE LOGIC ---
if (isset($_POST['save_item'])) {
    $id = $_POST['item_id'];
    $form_type = $_POST['form_type']; 
    
    if ($form_type == 'testimonial') {
        $category = 'testimonials';
        $title = $_POST['client_name'];
        $subtitle = $_POST['designation'];
        $description = $_POST['message'];
        $folder_type = 'testimonials';
    } else {
        $category = $_POST['category']; 
        $title = $_POST['title'];
        $subtitle = NULL;
        $description = $_POST['description'];
        $folder_type = 'gallery';
    }

    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $image_path = uploadImage($_FILES['image'], $folder_type);
    }

    if (!empty($id)) {
        if ($image_path) {
            $sql = "UPDATE gallery SET title=?, subtitle=?, description=?, category=?, image_path=? WHERE id=?";
            $params = [$title, $subtitle, $description, $category, $image_path, $id];
        } else {
            $sql = "UPDATE gallery SET title=?, subtitle=?, description=?, category=? WHERE id=?";
            $params = [$title, $subtitle, $description, $category, $id];
        }
    } else {
        if (!$image_path && $form_type == 'testimonial') {
            $image_path = "https://randomuser.me/api/portraits/lego/1.jpg";
        }
        $sql = "INSERT INTO gallery (title, subtitle, description, category, image_path) VALUES (?, ?, ?, ?, ?)";
        $params = [$title, $subtitle, $description, $category, $image_path];
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    header("Location: manage_gallery.php");
    exit();
}

// --- DATA FETCHING ---
$editItem = null;
$editType = '';

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($editItem) {
        if ($editItem['category'] == 'testimonials') $editType = 'testimonial';
        elseif ($editItem['category'] == 'achievements') $editType = 'achievement';
        else $editType = 'gallery';
    }
}

$achievementsList = $db->query("SELECT * FROM gallery WHERE category = 'achievements' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$galleryItems = $db->query("SELECT * FROM gallery WHERE category NOT IN ('achievements', 'testimonials') ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$testimonials = $db->query("SELECT * FROM gallery WHERE category = 'testimonials' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #1a3a8f; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 40px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #ff6b00; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; }
        img.thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .action-btn { text-decoration: none; padding: 5px 10px; border-radius: 3px; font-size: 0.9em; margin-right: 5px; }
        .btn-edit { background: #00a2e8; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .row { display: flex; gap: 30px; }
        .col { flex: 1; }
        .edit-mode { background-color: #e3f2fd; padding: 15px; border-radius: 5px; border-left: 5px solid #2196F3; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Content Management</h1>
    <p><a href="../Gallery.php" target="_blank">View Live Gallery Page</a></p>

    <h2>Manage Achievements</h2>
    <div class="row">
        <div class="col">
            <form action="" method="POST" enctype="multipart/form-data" class="<?php echo ($editType == 'achievement') ? 'edit-mode' : ''; ?>">
                <input type="hidden" name="form_type" value="achievement">
                <input type="hidden" name="item_id" value="<?php echo ($editType == 'achievement') ? $editItem['id'] : ''; ?>">
                <input type="hidden" name="category" value="achievements">
                <div class="form-group"><label>Title</label><input type="text" name="title" required value="<?php echo ($editType == 'achievement') ? $editItem['title'] : ''; ?>"></div>
                <div class="form-group"><label>Description</label><textarea name="description" rows="3"><?php echo ($editType == 'achievement') ? $editItem['description'] : ''; ?></textarea></div>
                <div class="form-group"><label>Image</label><input type="file" name="image" <?php echo ($editType == 'achievement') ? '' : 'required'; ?> accept="image/*"></div>
                <button type="submit" name="save_item"><?php echo ($editType == 'achievement') ? 'Update' : 'Add'; ?></button>
            </form>
        </div>
    </div>
    <table>
        <thead><tr><th>Image</th><th>Title</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach($achievementsList as $item): ?>
            <tr>
                <td><img src="<?php echo $item['image_path']; ?>" class="thumb"></td>
                <td><strong><?php echo htmlspecialchars($item['title']); ?></strong></td>
                <td><a href="?edit=<?php echo $item['id']; ?>" class="action-btn btn-edit">Edit</a><a href="?delete=<?php echo $item['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Sure?');">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Manage Gallery</h2>
    <div class="row">
        <div class="col">
            <form action="" method="POST" enctype="multipart/form-data" class="<?php echo ($editType == 'gallery') ? 'edit-mode' : ''; ?>">
                <input type="hidden" name="form_type" value="gallery">
                <input type="hidden" name="item_id" value="<?php echo ($editType == 'gallery') ? $editItem['id'] : ''; ?>">
                <div class="form-group"><label>Title</label><input type="text" name="title" required value="<?php echo ($editType == 'gallery') ? $editItem['title'] : ''; ?>"></div>
                <div class="form-group"><label>Description</label><textarea name="description" rows="3"><?php echo ($editType == 'gallery') ? $editItem['description'] : ''; ?></textarea></div>
                <div class="form-group"><label>Category</label>
                    <select name="category">
                        <?php $cat = ($editType == 'gallery') ? $editItem['category'] : 'events'; ?>
                        <option value="events" <?php echo $cat=='events'?'selected':''; ?>>Events</option>
                        <option value="team" <?php echo $cat=='team'?'selected':''; ?>>Team</option>
                        <option value="partners" <?php echo $cat=='partners'?'selected':''; ?>>Partners</option>
                    </select>
                </div>
                <div class="form-group"><label>Image</label><input type="file" name="image" <?php echo ($editType == 'gallery') ? '' : 'required'; ?> accept="image/*"></div>
                <button type="submit" name="save_item"><?php echo ($editType == 'gallery') ? 'Update' : 'Add'; ?></button>
            </form>
        </div>
    </div>
    <table>
        <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach($galleryItems as $item): ?>
            <tr>
                <td><img src="<?php echo $item['image_path']; ?>" class="thumb"></td>
                <td><strong><?php echo htmlspecialchars($item['title']); ?></strong></td>
                <td><?php echo ucfirst($item['category']); ?></td>
                <td><a href="?edit=<?php echo $item['id']; ?>" class="action-btn btn-edit">Edit</a><a href="?delete=<?php echo $item['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Sure?');">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Manage Testimonials</h2>
    <div class="row">
        <div class="col">
            <form action="" method="POST" enctype="multipart/form-data" class="<?php echo ($editType == 'testimonial') ? 'edit-mode' : ''; ?>">
                <input type="hidden" name="form_type" value="testimonial">
                <input type="hidden" name="item_id" value="<?php echo ($editType == 'testimonial') ? $editItem['id'] : ''; ?>">
                <div class="form-group"><label>Name</label><input type="text" name="client_name" required value="<?php echo ($editType == 'testimonial') ? $editItem['title'] : ''; ?>"></div>
                <div class="form-group"><label>Designation</label><input type="text" name="designation" value="<?php echo ($editType == 'testimonial') ? $editItem['subtitle'] : ''; ?>"></div>
                <div class="form-group"><label>Message</label><textarea name="message" rows="3" required><?php echo ($editType == 'testimonial') ? $editItem['description'] : ''; ?></textarea></div>
                <div class="form-group"><label>Photo</label><input type="file" name="image" accept="image/*"></div>
                <button type="submit" name="save_item"><?php echo ($editType == 'testimonial') ? 'Update' : 'Add'; ?></button>
            </form>
        </div>
    </div>
    <table>
        <thead><tr><th>Image</th><th>Name</th><th>Message</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach($testimonials as $t): ?>
            <tr>
                <td><img src="<?php echo $t['image_path']; ?>" class="thumb"></td>
                <td><strong><?php echo htmlspecialchars($t['title']); ?></strong><br><?php echo htmlspecialchars($t['subtitle']); ?></td>
                <td><?php echo substr(htmlspecialchars($t['description']), 0, 50); ?>...</td>
                <td><a href="?edit=<?php echo $t['id']; ?>" class="action-btn btn-edit">Edit</a><a href="?delete=<?php echo $t['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Sure?');">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>