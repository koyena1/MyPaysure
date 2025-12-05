<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php"); exit;
}
include '../includes/db.php';
$sponsor_id = $_SESSION['username'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $position = $_POST['position'];

    // Check if username exists
    $check = $db->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);
    if ($check->rowCount() > 0) {
        $message = "<div class='alert alert-danger'>Username already exists!</div>";
    } else {
        try {
            $db->beginTransaction();

            // 1. Users Table (Login)
            $stmt = $db->prepare("INSERT INTO users (username, password_hash, full_name, email, role, is_active) VALUES (?, ?, ?, ?, 'user', 1)");
            $stmt->execute([$username, $password, $full_name, $email]);

            // 2. Registrations Table (MLM Data)
            $stmt = $db->prepare("INSERT INTO registrations (sponsor_id, sponsor_name, position, full_name, mobile, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$sponsor_id, $_SESSION['full_name'], $position, $full_name, $mobile, $email]);

            // 3. User Details Table (Wallet)
            $stmt = $db->prepare("INSERT INTO user_details (member_id, member_name, sponsor_id, available_balance, status) VALUES (?, ?, ?, 0.00, 'Active')");
            $stmt->execute([$username, $full_name, $sponsor_id]);
            
            // 4. Update My Directs (Optional Helper Table)
            $stmt = $db->prepare("INSERT INTO my_directs (member_id, name, mobile, sponsor_id, sponsor_name, active_status) VALUES (?, ?, ?, ?, ?, 'Active')");
            $stmt->execute([$username, $full_name, $mobile, $sponsor_id, $_SESSION['full_name']]);

            $db->commit();
            $message = "<div class='alert alert-success'>New Member Registered Successfully!</div>";
        } catch (Exception $e) {
            $db->rollBack();
            $message = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}

?>

<div class="card-box">
    <h3>Register New Member</h3>
    <?php echo $message; ?>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Sponsor ID (You)</label>
                <input type="text" class="form-control" value="<?php echo $sponsor_id; ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Position</label>
                <select name="position" class="form-control">
                    <option value="Left">Left</option>
                    <option value="Right">Right</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>New User Member ID (Username)</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Register Member</button>
            </div>
        </div>
    </form>
</div>
</div></div></body></html>