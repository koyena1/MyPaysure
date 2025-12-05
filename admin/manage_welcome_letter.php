<?php
// 1. Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "paysure_insurance";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// --- HANDLE ACTIONS ---
$message = "";

// A. Send Letter
if (isset($_GET['action']) && $_GET['action'] == 'send' && isset($_GET['id'])) {
    $uid = intval($_GET['id']);
    $conn->query("UPDATE users SET welcome_letter_sent = 1 WHERE id = $uid");
    $message = "<div class='alert alert-success'>Letter activated for User ID: $uid</div>";
}

// B. Delete User
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $uid = intval($_GET['id']);
    $conn->query("DELETE FROM users WHERE id = $uid");
    $message = "<div class='alert alert-danger'>User deleted.</div>";
}

// C. Update User Details (NOW INCLUDES ADDRESS)
if (isset($_POST['update_user'])) {
    $uid = intval($_POST['user_id']);
    $u_name = $conn->real_escape_string($_POST['full_name']);
    $u_username = $conn->real_escape_string($_POST['username']);
    $u_email = $conn->real_escape_string($_POST['email']);
    $u_address = $conn->real_escape_string($_POST['address']); // New Address Field
    
    $conn->query("UPDATE users SET full_name='$u_name', username='$u_username', email='$u_email', address='$u_address' WHERE id=$uid");
    $message = "<div class='alert alert-success'>User details updated successfully!</div>";
}

// D. Update Letter Settings
if (isset($_POST['update_settings'])) {
    $header_title = $conn->real_escape_string($_POST['header_title']);
    $tagline = $conn->real_escape_string($_POST['tagline']);
    $greeting_text = $conn->real_escape_string($_POST['greeting_text']);
    $intro_paragraph = $conn->real_escape_string($_POST['intro_paragraph']);
    $highlight_text = $conn->real_escape_string($_POST['highlight_text']);
    $step_section_title = $conn->real_escape_string($_POST['step_section_title']);
    $footer_text = $conn->real_escape_string($_POST['footer_text']);
    $address = $conn->real_escape_string($_POST['address']);

    // Check if row 1 exists
    $check = $conn->query("SELECT id FROM welcome_letter_settings WHERE id=1");
    if($check->num_rows == 0) {
        $sql = "INSERT INTO welcome_letter_settings (id, header_title, tagline, greeting_text, intro_paragraph, highlight_text, step_section_title, footer_text, address) 
                VALUES (1, '$header_title', '$tagline', '$greeting_text', '$intro_paragraph', '$highlight_text', '$step_section_title', '$footer_text', '$address')";
    } else {
        $sql = "UPDATE welcome_letter_settings SET header_title='$header_title', tagline='$tagline', greeting_text='$greeting_text', intro_paragraph='$intro_paragraph', highlight_text='$highlight_text', step_section_title='$step_section_title', footer_text='$footer_text', address='$address' WHERE id=1";
    }
    
    if($conn->query($sql)) {
        $message = "<div class='alert alert-success'>Settings Saved!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// --- FETCH DATA ---
$data = [
    'header_title' => 'PAYSURE', 'tagline' => 'Caring For Your Life',
    'greeting_text' => 'Dear Valued Partner,', 'intro_paragraph' => 'Welcome to PaySure...',
    'highlight_text' => 'To empower individuals...', 'step_section_title' => 'Action Required',
    'footer_text' => 'PaySure Team', 'address' => ''
];

$result = $conn->query("SELECT * FROM welcome_letter_settings WHERE id=1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data = array_merge($data, $row);
}

// Fetch Users
$users_result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Welcome Letter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; padding: 20px; }
        .admin-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="container">
    <?php echo $message; ?>

    <div class="admin-card">
        <h2 class="mb-4 text-primary"><i class="fas fa-users"></i> Users & Letters</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th> <th>User</th> <th>Status</th> <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users_result && $users_result->num_rows > 0): ?>
                        <?php while($user = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($user['full_name']); ?></strong><br>
                                    <small>@<?php echo htmlspecialchars($user['username']); ?></small>
                                </td>
                                <td>
                                    <?php if(isset($user['welcome_letter_sent']) && $user['welcome_letter_sent'] == 1): ?>
                                        <span class="badge bg-success">Sent</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Not Sent</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!isset($user['welcome_letter_sent']) || $user['welcome_letter_sent'] == 0): ?>
                                        <a href="?action=send&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-success">Send</a>
                                    <?php else: ?>
                                        <a href="../welcome_letter.php?user_id=<?php echo $user['id']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    <?php endif; ?>
                                    
                                    <button class="btn btn-sm btn-info text-white" 
                                            onclick="openEditModal(<?php echo $user['id']; ?>, '<?php echo $user['full_name']; ?>', '<?php echo $user['username']; ?>', '<?php echo $user['email']; ?>', '<?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?>')">Edit</button>
                                    
                                    <a href="?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card">
        <h4>Letter Template</h4>
        <form method="POST" action="">
            <input type="hidden" name="update_settings" value="1">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Header Title</label>
                    <input type="text" name="header_title" class="form-control" value="<?php echo htmlspecialchars($data['header_title']); ?>">
                </div>
                <div class="col-md-6">
                    <label>Tagline</label>
                    <input type="text" name="tagline" class="form-control" value="<?php echo htmlspecialchars($data['tagline']); ?>">
                </div>
            </div>
            <div class="mb-3"><label>Greeting</label><input type="text" name="greeting_text" class="form-control" value="<?php echo htmlspecialchars($data['greeting_text']); ?>"></div>
            <div class="mb-3"><label>Intro Paragraph</label><textarea name="intro_paragraph" class="form-control" rows="3"><?php echo htmlspecialchars($data['intro_paragraph']); ?></textarea></div>
            <div class="mb-3"><label>Highlights</label><textarea name="highlight_text" class="form-control" rows="2"><?php echo htmlspecialchars($data['highlight_text']); ?></textarea></div>
            <div class="mb-3"><label>Steps Title</label><input type="text" name="step_section_title" class="form-control" value="<?php echo htmlspecialchars($data['step_section_title']); ?>"></div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                     <label>Footer Text</label>
                     <input type="text" name="footer_text" class="form-control" value="<?php echo htmlspecialchars($data['footer_text']); ?>">
                </div>
                <div class="col-md-6">
                     <label>Office Address (Footer)</label>
                     <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($data['address']); ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-dark w-100">Save Template</button>
        </form>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
          <div class="modal-header"><h5 class="modal-title">Edit User Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
          <div class="modal-body">
            <input type="hidden" name="update_user" value="1">
            <input type="hidden" name="user_id" id="modal_user_id">
            
            <div class="mb-2"><label>Name</label><input type="text" name="full_name" id="modal_full_name" class="form-control" required></div>
            <div class="mb-2"><label>Username</label><input type="text" name="username" id="modal_username" class="form-control" required></div>
            <div class="mb-2"><label>Email</label><input type="text" name="email" id="modal_email" class="form-control" required></div>
            
            <div class="mb-2"><label>Employee Address</label><textarea name="address" id="modal_address" class="form-control" rows="2"></textarea></div>
          
          </div>
          <div class="modal-footer"><button type="submit" class="btn btn-primary">Save Changes</button></div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openEditModal(id, name, username, email, address) {
        document.getElementById('modal_user_id').value = id;
        document.getElementById('modal_full_name').value = name;
        document.getElementById('modal_username').value = username;
        document.getElementById('modal_email').value = email;
        document.getElementById('modal_address').value = address; // Populate address
        new bootstrap.Modal(document.getElementById('editUserModal')).show();
    }
</script>
</body>
</html>