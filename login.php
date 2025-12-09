<?php
session_start();

// 1. DATABASE CONNECTION & FUNCTIONS
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Ensure $pdo variable is available
if (!isset($pdo) && isset($db)) { $pdo = $db; }

$login_error = "";
$register_message = "";
$register_msg_type = "";

// --- HELPER FUNCTION: Find Extreme Leg Placement ---
function findExtremeLegPlacement($pdo, $sponsorId, $chosenLeg) {
    $currentId = $sponsorId;
    while (true) {
        $stmt = $pdo->prepare("SELECT distributor_id FROM network_structure WHERE parent_id = ? AND leg_type = ?");
        $stmt->execute([$currentId, $chosenLeg]);
        $existingNode = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingNode) {
            return ['parent_id' => $currentId, 'position' => $chosenLeg];
        }
        $currentId = $existingNode['distributor_id'];
    }
}

// --- HELPER FUNCTION: Generate Smart Sequential ID ---
// Format: [2 Random Letters] [ID + 10000] [1 Random Letter]
// Example: User ID 5 -> AB10005X
function generateSmartID($userId) {
    // 1. Generate 2 Random Uppercase Letters
    $prefix = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 2);
    
    // 2. Create Sequential Number (ID + Offset to look professional)
    // We add 10000 so the first user looks like ID #10001
    $offset = 10000;
    $sequence = $userId + $offset;
    
    // 3. Generate 1 Random Suffix Letter
    $suffix = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);
    
    return $prefix . $sequence . $suffix;
}

// 2. LOGIN LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'signin') {
    $username_in = $_POST['username'] ?? '';
    $password_in = $_POST['password'] ?? '';

    if (!empty($username_in) && !empty($password_in)) {
        try {
            // Allow login via Username, Email, OR Member Code
            $stmt = $pdo->prepare("SELECT id, username, member_code, password_hash, full_name, email, role, is_active FROM users WHERE username = ? OR email = ? OR member_code = ?");
            $stmt->execute([$username_in, $username_in, $username_in]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password_in, $user['password_hash']) && $user['is_active'] == 1) {
                    $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $updateStmt->execute([$user['id']]);

                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    // Store the Member Code in session
                    $_SESSION['member_code'] = !empty($user['member_code']) ? $user['member_code'] : $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header("Location: admin/dashboard.php");
                    } else {
                        header("Location: user/client_dashboard.php"); 
                    }
                    exit;
                } else {
                    $login_error = "Invalid credentials or account inactive.";
                }
            } else {
                $login_error = "Invalid credentials.";
            }
        } catch(PDOException $e) {
            $login_error = "System error: " . $e->getMessage();
        }
    } else {
        $login_error = "Please enter all fields.";
    }
}

// 3. REGISTRATION LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'signup') {
    
    $sponsor_input  = trim($_POST['sponsor_id']); 
    $full_name      = trim($_POST['fullname']);
    $username_input = trim($_POST['username']); 
    $mobile         = trim($_POST['mobile']);
    $email          = trim($_POST['email']);
    $raw_password   = $_POST['password'];
    $selected_leg   = $_POST['position'] ?? 'Left';

    if(empty($sponsor_input) || empty($username_input)) {
        $register_message = "Sponsor ID and Username are required.";
        $register_msg_type = "error";
    } else {
        try {
            // A. Check Duplicates
            $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $checkStmt->execute([$email, $username_input]);
            
            if ($checkStmt->rowCount() > 0) {
                $register_message = "Email or Username already exists!";
                $register_msg_type = "error";
            } else {
                // B. Validate Sponsor (Check by username, member_code, or my_spon_id)
                $sponStmt = $pdo->prepare("SELECT id, full_name, username FROM users WHERE my_spon_id = ? OR username = ? OR member_code = ?");
                $sponStmt->execute([$sponsor_input, $sponsor_input, $sponsor_input]);
                $sponsorData = $sponStmt->fetch(PDO::FETCH_ASSOC);

                if (!$sponsorData) {
                    $register_message = "Invalid Sponsor ID! Please check again.";
                    $register_msg_type = "error";
                } else {
                    $sponsor_db_id = $sponsorData['id'];

                    if ($selected_leg !== 'Left' && $selected_leg !== 'Right') {
                        $selected_leg = 'Left';
                    }

                    // C. Find Placement
                    $placement = findExtremeLegPlacement($pdo, $sponsor_db_id, $selected_leg);
                    $parent_db_id = $placement['parent_id'];
                    $position     = $placement['position'];

                    $pStmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
                    $pStmt->execute([$parent_db_id]);
                    $parentName = $pStmt->fetchColumn();

                    // --- TRANSACTION STARTS ---
                    $pdo->beginTransaction();

                    try {
                        // 1. Insert into USERS (Initially with NULL member_code)
                        $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);
                        // Note: We insert NULL for member_code first, then update it after getting ID
                        $sqlUser = "INSERT INTO users (username, member_code, password_hash, email, full_name, mobile, role, is_active, created_at, sponsor_id) VALUES (?, NULL, ?, ?, ?, ?, 'user', 1, NOW(), ?)";
                        $stmtUser = $pdo->prepare($sqlUser);
                        $stmtUser->execute([$username_input, $password_hash, $email, $full_name, $mobile, $sponsorData['username']]);
                        $new_user_id = $pdo->lastInsertId();

                        // 2. GENERATE SMART ID & UPDATE USER
                        // Using the new logic: [2 Random Letters] [ID + 10000] [1 Random Letter]
                        $new_smart_id = generateSmartID($new_user_id);

                        // Update both member_code AND my_spon_id to be this new Smart ID
                        // This allows users to share this code as their Sponsor ID
                        $updateUser = $pdo->prepare("UPDATE users SET member_code = ?, my_spon_id = ? WHERE id = ?");
                        $updateUser->execute([$new_smart_id, $new_smart_id, $new_user_id]);

                        // 3. Insert into NETWORK_STRUCTURE
                        $sqlNet = "INSERT INTO network_structure (distributor_id, parent_id, sponsor_id, leg_type, created_at) VALUES (?, ?, ?, ?, NOW())";
                        $stmtNet = $pdo->prepare($sqlNet);
                        $stmtNet->execute([$new_user_id, $parent_db_id, $sponsor_db_id, $position]);

                        // 4. Update Upline Counts
                        if (function_exists('updateUplineCounts')) {
                            updateUplineCounts($pdo, $parent_db_id, $new_user_id, $position);
                        }

                        // 5. Insert into MY_DIRECTS
                        $sqlDirect = "INSERT INTO my_directs (member_id, name, mobile, sponsor_id, sponsor_name, parent_id, parent_name, active_status, date_of_joining) VALUES (?, ?, ?, ?, ?, ?, ?, 'Active', NOW())";
                        $stmtDirect = $pdo->prepare($sqlDirect);
                        $stmtDirect->execute([$new_user_id, $full_name, $mobile, $sponsor_db_id, $sponsorData['full_name'], $parent_db_id, $parentName]);

                        $pdo->commit();

                        $_SESSION['loggedin'] = true;
                        $_SESSION['user_id'] = $new_user_id;
                        $_SESSION['username'] = $username_input;
                        $_SESSION['member_code'] = $new_smart_id; 
                        $_SESSION['full_name'] = $full_name;
                        $_SESSION['role'] = 'user';

                        header("Location: user/client_dashboard.php");
                        exit;

                    } catch (Exception $e) {
                        if ($pdo->inTransaction()) { $pdo->rollBack(); }
                        $register_message = "Registration Error: " . $e->getMessage();
                        $register_msg_type = "error";
                    }
                }
            }
        } catch(PDOException $e) {
            $register_message = "Database error: " . $e->getMessage();
            $register_msg_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Paysure - Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root { --purple-1: #4b1f9b; --purple-2: #6a34e6; --white: #ffffff; --gray: #eee; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; display: flex; justify-content: center; align-items: center; flex-direction: column; height: 100vh; overflow: hidden; }
    .bg-video { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; object-fit: cover; filter: brightness(0.7); }
    .container { background-color: var(--white); border-radius: 20px; box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22); position: relative; overflow: hidden; width: 850px; max-width: 100%; min-height: 650px; }
    .form-container { position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; }
    form { background-color: var(--white); display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 50px; height: 100%; text-align: center; }
    h1 { font-weight: 700; margin: 0; margin-bottom: 10px; font-size: 24px;}
    span { font-size: 12px; color: #666; margin-bottom: 10px; }
    .social-container { margin: 10px 0; }
    .social-container a { border: 1px solid #ddd; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; margin: 0 5px; height: 35px; width: 35px; color: #333; text-decoration: none; transition: 0.3s; }
    .social-container a:hover { background: #eee; }
    input, select { background-color: #eee; border: none; padding: 10px 15px; margin: 5px 0; width: 100%; border-radius: 8px; outline: none; font-size: 13px; }
    select { cursor: pointer; color: #333; }
    .forgot-pass { color: #333; font-size: 12px; text-decoration: none; margin: 10px 0; }
    button { border-radius: 20px; border: 1px solid var(--purple-1); background-color: var(--purple-1); color: #ffffff; font-size: 12px; font-weight: bold; padding: 12px 45px; letter-spacing: 1px; text-transform: uppercase; transition: transform 80ms ease-in; cursor: pointer; margin-top: 10px; }
    button:active { transform: scale(0.95); }
    button:focus { outline: none; }
    button.ghost { background-color: transparent; border-color: #ffffff; }
    .sign-in-container { left: 0; width: 50%; z-index: 2; }
    .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }
    .container.right-panel-active .sign-in-container { transform: translateX(100%); }
    .container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s; }
    @keyframes show { 0%, 49.99% { opacity: 0; z-index: 1; } 50%, 100% { opacity: 1; z-index: 5; } }
    .overlay-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100; border-top-left-radius: 100px; border-bottom-left-radius: 100px; }
    .container.right-panel-active .overlay-container { transform: translateX(-100%); border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: 100px; border-bottom-right-radius: 100px; }
    .overlay { background: linear-gradient(to right, var(--purple-1), var(--purple-2)); background-repeat: no-repeat; background-size: cover; background-position: 0 0; color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
    .container.right-panel-active .overlay { transform: translateX(50%); }
    .overlay-panel { position: absolute; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%; transform: translateX(0); transition: transform 0.6s ease-in-out; }
    .overlay-left { transform: translateX(-20%); }
    .container.right-panel-active .overlay-left { transform: translateX(0); }
    .overlay-right { right: 0; transform: translateX(0); }
    .container.right-panel-active .overlay-right { transform: translateX(20%); }
    @media (max-width: 768px) { .container { width: 90%; min-height: 650px; } form { padding: 0 20px; } }
</style>
</head>
<body>
<video autoplay muted loop class="bg-video">
    <source src="WhatsApp Video 2025-11-22 at 6.57.51 PM.mp4" type="video/mp4">
</video>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="" method="POST">
            <input type="hidden" name="action" value="signup">
            <h1>Create Account</h1>
            <?php if($register_message != ""): ?>
                <div style="padding: 8px; margin-bottom: 5px; border-radius: 5px; width: 100%; text-align: center; font-size: 12px;
                    background-color: <?php echo ($register_msg_type == 'success') ? '#d4edda' : '#f8d7da'; ?>;
                    color: <?php echo ($register_msg_type == 'success') ? '#155724' : '#721c24'; ?>;">
                    <?php echo $register_message; ?>
                </div>
            <?php endif; ?>
            <input type="text" name="sponsor_id" placeholder="Sponsor ID (e.g. AZ10025P)" required />
            
            <select name="position" required>
                <option value="" disabled selected>Select Position</option>
                <option value="Left">Left Leg</option>
                <option value="Right">Right Leg</option>
            </select>

            <input type="text" name="fullname" placeholder="Full Name" required />
            <input type="text" name="username" placeholder="Username (Unique)" required />
            <input type="text" name="mobile" placeholder="Mobile Number" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="" method="POST">
            <input type="hidden" name="action" value="signin">
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your account</span>
            <?php if($login_error != ""): ?>
                <div style="padding: 10px; margin-bottom: 10px; border-radius: 5px; width: 100%; text-align: center; font-size: 14px; background-color: #f8d7da; color: #721c24;">
                    <?php echo $login_error; ?>
                </div>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Email / Username / Member ID" required />
            <input type="password" name="password" placeholder="Password" required />
            <a href="#" class="forgot-pass">Forgot your password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and join our network</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    signUpButton.addEventListener('click', () => { container.classList.add("right-panel-active"); });
    signInButton.addEventListener('click', () => { container.classList.remove("right-panel-active"); });
    <?php if($register_message != "" && $register_msg_type == 'error'): ?>
        container.classList.add("right-panel-active");
    <?php endif; ?>
</script>
</body>
</html>