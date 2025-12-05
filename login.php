<?php
session_start();

// 1. DATABASE CONNECTION
// Explicitly defined to prevent "$pdo on null" errors
require_once 'includes/db.php';

// --- HELPER FUNCTION: Find Placement (Binary Tree BFS) ---
function findPlacement($pdo, $rootSponsorUsername) {
    $queue = [$rootSponsorUsername];

    while (count($queue) > 0) {
        $currentUser = array_shift($queue);

        // Check Left Leg
        $stmt = $pdo->prepare("SELECT full_name, member_code FROM registrations WHERE sponsor_id = ? AND position = 'Left'");
        $stmt->execute([$currentUser]);
        $leftLeg = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$leftLeg) {
            return ['parent_username' => $currentUser, 'position' => 'Left'];
        }

        // Check Right Leg
        $stmt = $pdo->prepare("SELECT full_name, member_code FROM registrations WHERE sponsor_id = ? AND position = 'Right'");
        $stmt->execute([$currentUser]);
        $rightLeg = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$rightLeg) {
            return ['parent_username' => $currentUser, 'position' => 'Right'];
        }

        // If both full, add children to queue to search deeper
        $queue[] = $leftLeg['member_code'];
        $queue[] = $rightLeg['member_code'];
    }
    return null;
}
// ---------------------------------------------------------

$login_error = "";
$register_message = "";
$register_msg_type = "";

// 2. LOGIN LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'signin') {
    $username_in = $_POST['username'] ?? '';
    $password_in = $_POST['password'] ?? '';

    if (!empty($username_in) && !empty($password_in)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash, full_name, email, role, is_active FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username_in, $username_in]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password_in, $user['password_hash']) && $user['is_active'] == 1) {
                    // Update last login
                    $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $updateStmt->execute([$user['id']]);

                    // Set Session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];

                    // --- REDIRECT LOGIC UPDATED ---
                    if ($user['role'] === 'admin') {
                        header("Location: admin/dashboard.php");
                    } else {
                        // Redirect to DASHBOARD, not tree
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

// 3. REGISTRATION LOGIC (With Binary Tree Integration)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'signup') {
    
    // Inputs
    $sponsor_input = trim($_POST['sponsor_id']); // e.g. SPON1
    $full_name = trim($_POST['fullname']);
    $username_input = trim($_POST['username']); 
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $raw_password = $_POST['password'];

    // Validation
    if(empty($sponsor_input) || empty($username_input)) {
        $register_message = "Sponsor ID and Username are required.";
        $register_msg_type = "error";
    } else {
        try {
            // Check Duplicates
            $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $checkStmt->execute([$email, $username_input]);
            
            if ($checkStmt->rowCount() > 0) {
                $register_message = "Email or Username already exists!";
                $register_msg_type = "error";
            } else {
                // Validate Sponsor
                $sponsor_id_clean = str_replace("SPON", "", strtoupper($sponsor_input));
                $sponStmt = $pdo->prepare("SELECT id, username, full_name FROM users WHERE id = ?");
                $sponStmt->execute([$sponsor_id_clean]);
                $sponsorData = $sponStmt->fetch(PDO::FETCH_ASSOC);

                if (!$sponsorData) {
                    $register_message = "Invalid Sponsor ID!";
                    $register_msg_type = "error";
                } else {
                    // Find Tree Placement
                    $placement = findPlacement($pdo, $sponsorData['username']);

                    if (!$placement) {
                        $register_message = "No placement slot found in tree.";
                        $register_msg_type = "error";
                    } else {
                        $parent_username = $placement['parent_username'];
                        $position = $placement['position'];

                        // Begin Transaction
                        $pdo->beginTransaction();

                        // 1. Insert User
                        $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);
                        $sqlUser = "INSERT INTO users (username, password_hash, email, full_name, role, is_active) VALUES (?, ?, ?, ?, 'user', 1)";
                        $stmtUser = $pdo->prepare($sqlUser);
                        $stmtUser->execute([$username_input, $password_hash, $email, $full_name]);
                        $new_user_id = $pdo->lastInsertId();

                        // 2. Insert into Registrations (Tree Structure)
                        // Fetch parent details for name
                        $pStmt = $pdo->prepare("SELECT full_name FROM users WHERE username = ?");
                        $pStmt->execute([$parent_username]);
                        $parentName = $pStmt->fetchColumn();

                        $sqlReg = "INSERT INTO registrations 
                            (sponsor_id, sponsor_name, position, full_name, mobile, email, member_code, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
                        $stmtReg = $pdo->prepare($sqlReg);
                        $stmtReg->execute([
                            $parent_username, // Visual Parent
                            $parentName,
                            $position,
                            $full_name,
                            $mobile,
                            $email,
                            $username_input
                        ]);

                        // 3. Insert into My Directs (Referral Tracking)
                        $sqlDirect = "INSERT INTO my_directs 
                            (member_id, name, mobile, sponsor_id, sponsor_name, parent_id, parent_name, active_status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, 'Active')";
                        $stmtDirect = $pdo->prepare($sqlDirect);
                        $stmtDirect->execute([
                            $new_user_id,
                            $full_name,
                            $mobile,
                            $sponsor_id_clean, // Actual Referrer ID
                            $sponsorData['full_name'],
                            $parent_username,
                            $parentName
                        ]);

                        $pdo->commit();
                        $register_message = "Success! Your ID: SPON$new_user_id. Placed under $parentName ($position).";
                        $register_msg_type = "success";
                    }
                }
            }
        } catch(PDOException $e) {
            $pdo->rollBack();
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
    /* --- CSS RESET & VARIABLES --- */
    :root {
        --purple-1: #4b1f9b;
        --purple-2: #6a34e6;
        --white: #ffffff;
        --gray: #eee;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }

    /* --- VIDEO BACKGROUND --- */
    .bg-video {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: -2;
        object-fit: cover;
        filter: brightness(0.7);
    }

    /* --- MAIN CONTAINER --- */
    .container {
        background-color: var(--white);
        border-radius: 20px;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        position: relative;
        overflow: hidden;
        width: 850px;
        max-width: 100%;
        min-height: 600px; /* Increased height for extra inputs */
    }

    /* --- FORMS CONFIGURATION --- */
    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    form {
        background-color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    h1 { font-weight: 700; margin: 0; margin-bottom: 10px; font-size: 24px;}
    span { font-size: 12px; color: #666; margin-bottom: 10px; }
    
    .social-container { margin: 10px 0; }
    .social-container a {
        border: 1px solid #ddd; border-radius: 50%; display: inline-flex;
        justify-content: center; align-items: center; margin: 0 5px;
        height: 35px; width: 35px; color: #333; text-decoration: none; transition: 0.3s;
    }
    .social-container a:hover { background: #eee; }

    input {
        background-color: #eee; border: none; padding: 10px 15px;
        margin: 5px 0; width: 100%; border-radius: 8px; outline: none; font-size: 13px;
    }

    .forgot-pass { color: #333; font-size: 12px; text-decoration: none; margin: 10px 0; }
    
    button {
        border-radius: 20px; border: 1px solid var(--purple-1);
        background-color: var(--purple-1); color: #ffffff;
        font-size: 12px; font-weight: bold; padding: 12px 45px;
        letter-spacing: 1px; text-transform: uppercase;
        transition: transform 80ms ease-in; cursor: pointer; margin-top: 10px;
    }
    button:active { transform: scale(0.95); }
    button:focus { outline: none; }
    button.ghost { background-color: transparent; border-color: #ffffff; }

    /* --- ANIMATION STATES --- */
    .sign-in-container { left: 0; width: 50%; z-index: 2; }
    .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

    .container.right-panel-active .sign-in-container { transform: translateX(100%); }
    .container.right-panel-active .sign-up-container {
        transform: translateX(100%); opacity: 1; z-index: 5; animation: show 0.6s;
    }

    @keyframes show { 0%, 49.99% { opacity: 0; z-index: 1; } 50%, 100% { opacity: 1; z-index: 5; } }

    /* --- OVERLAY --- */
    .overlay-container {
        position: absolute; top: 0; left: 50%; width: 50%; height: 100%;
        overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100;
        border-top-left-radius: 100px; border-bottom-left-radius: 100px;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
        border-top-left-radius: 0; border-bottom-left-radius: 0;
        border-top-right-radius: 100px; border-bottom-right-radius: 100px;
    }

    .overlay {
        background: linear-gradient(to right, var(--purple-1), var(--purple-2));
        background-repeat: no-repeat; background-size: cover; background-position: 0 0;
        color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%;
        transform: translateX(0); transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay { transform: translateX(50%); }

    .overlay-panel {
        position: absolute; display: flex; align-items: center; justify-content: center;
        flex-direction: column; padding: 0 40px; text-align: center;
        top: 0; height: 100%; width: 50%; transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left { transform: translateX(-20%); }
    .container.right-panel-active .overlay-left { transform: translateX(0); }
    .overlay-right { right: 0; transform: translateX(0); }
    .container.right-panel-active .overlay-right { transform: translateX(20%); }
    
    /* Responsive */
    @media (max-width: 768px) {
        .container { width: 90%; min-height: 600px; }
        form { padding: 0 20px; }
    }
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

            <input type="text" name="sponsor_id" placeholder="Sponsor ID (e.g. SPON1)" required />
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

            <input type="text" name="username" placeholder="Email or Username" required />
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

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    // KEEP PANEL OPEN ON ERROR OR SUCCESS
    <?php if($register_message != ""): ?>
        container.classList.add("right-panel-active");
    <?php endif; ?>
</script>

</body>
</html>