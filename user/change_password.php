<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
$member_id = $_SESSION['username']; // This is the username in the users table
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Fetch User Data
    $stmt = $db->prepare("SELECT password_hash FROM users WHERE username = ?");
    $stmt->execute([$member_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 2. Verify Old Password
        if (password_verify($current_pass, $user['password_hash'])) {
            // 3. Check if New Passwords Match
            if ($new_pass === $confirm_pass) {
                // 4. Update Password
                $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $update = $db->prepare("UPDATE users SET password_hash = ? WHERE username = ?");
                
                if ($update->execute([$new_hash, $member_id])) {
                    $msg = "<div class='alert alert-success'>Password changed successfully!</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Database error. Try again.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>New passwords do not match!</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Current password is incorrect!</div>";
        }
    }
}
?>

<div class="card-box" style="max-width: 600px; margin: 0 auto;">
    <h3><i class="fa fa-lock me-2"></i> Change Password</h3>
    <?php echo $msg; ?>
    
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required minlength="6">
            <small class="text-muted">Minimum 6 characters</small>
        </div>
        
        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning w-100">Update Password</button>
    </form>
</div>
</div></div></body></html>