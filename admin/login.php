<?php
// --- 1. Backend Logic ---
session_start();
// Adjust this path if your db.php is in a different folder relative to login.php
require_once '../includes/db.php'; 

$login_error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        
        // ADDED 'full_name' to the select query
        $sql = "SELECT id, username, password_hash, role, full_name FROM users WHERE username = ? AND is_active = 1";
        
        $user = $database->fetch($sql, [$username]);

        if ($user) {
            // Verify Password
            if (password_verify($password, $user['password_hash'])) {
                
                // --- CRITICAL FIXES HERE ---
                $_SESSION['loggedin'] = true; // This was missing
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name']; // This was missing
                $_SESSION['role'] = $user['role'];

                // Redirect based on Role
                if ($user['role'] === 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                $login_error = "Invalid password. Please try again.";
            }
        } else {
            $login_error = "User not found or account is inactive.";
        }
    } else {
        $login_error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Portal - Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ... Your Existing CSS ... */
        /* (Keep the CSS exactly as you had it in your code) */
        :root {
            --teal-dark: #004D40;
            --teal-light: #00897B;
            --accent-yellow: #FFC107;
            --accent-glow: #FFD54F;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.3);
            --text-dark: #1f2937;
            --text-light: #f3f4f6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            height: 100vh;
            width: 100%;
            background: linear-gradient(135deg, #004d40 0%, #00695c 40%, #00897b 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .blob { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 1; opacity: 0.6; }
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: #FFC107; }
        .blob-2 { bottom: -10%; right: -10%; width: 600px; height: 600px; background: #00251a; }

        .container { position: relative; z-index: 10; display: flex; width: 90%; max-width: 1100px; height: 650px; align-items: center; justify-content: center; gap: 20px; }

        .form-box {
            background: var(--glass-bg); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            padding: 60px 50px; border-radius: 30px; width: 450px;
            display: flex; flex-direction: column; justify-content: center; transition: transform 0.3s ease;
        }
        .form-box:hover { transform: translateY(-5px); }

        .form-title { color: #ffffff; font-size: 2rem; font-weight: 700; text-align: center; letter-spacing: 2px; margin-bottom: 40px; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }

        .input-group { position: relative; margin-bottom: 35px; }
        .input-group input { width: 100%; padding: 15px 10px; border: none; background: rgba(255, 255, 255, 0.1); border-radius: 8px; border-bottom: 2px solid transparent; font-size: 1rem; color: white; outline: none; transition: all 0.3s ease; }
        .input-group input::placeholder { color: rgba(255,255,255, 0.6); }
        .input-group label { position: absolute; left: 10px; top: -22px; color: var(--accent-yellow); font-weight: 600; font-size: 0.85rem; letter-spacing: 0.5px; pointer-events: none; transition: 0.3s; }
        .input-group input:focus { background: rgba(255, 255, 255, 0.2); border-bottom: 2px solid var(--accent-yellow); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .options { display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; }
        .options input[type="checkbox"] { accent-color: var(--accent-yellow); cursor: pointer; }
        .options label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .options a { text-decoration: none; color: var(--accent-yellow); font-weight: 500; transition: color 0.3s; }
        .options a:hover { color: #fff; text-decoration: underline; }

        .btn-submit {
            width: 100%; background: linear-gradient(45deg, var(--accent-yellow), #FF8F00); color: #333;
            font-size: 1.1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 15px;
            border: none; border-radius: 50px; cursor: pointer; box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
            transition: all 0.3s ease; position: relative; overflow: hidden;
        }
        .btn-submit::after { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); transition: 0.5s; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(255, 193, 7, 0.4); }
        .btn-submit:hover::after { left: 100%; }

        .image-box { width: 500px; display: flex; justify-content: center; align-items: center; animation: float 6s ease-in-out infinite; }
        .illustration { width: 100%; height: auto; object-fit: contain; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4)); }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }

        @media (max-width: 950px) {
            .container { flex-direction: column-reverse; height: auto; padding: 40px 20px; }
            .form-box { width: 100%; max-width: 450px; }
            .image-box { width: 80%; margin-bottom: 30px; }
        }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container">
        <div class="form-box">
            <h2 class="form-title">Welcome Back</h2>

            <form id="loginForm" method="POST" action="">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your ID" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="options">
                    <label>
                        <input type="checkbox" id="rememberMe"> Remember me
                    </label>
                    <a href="#" id="forgotPassLink">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-submit">Log In</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('loginForm');
            const usernameInput = document.getElementById('username');
            const rememberMeCheckbox = document.getElementById('rememberMe');
            const forgotPassLink = document.getElementById('forgotPassLink');

            const savedUser = localStorage.getItem('savedUsername');
            if (savedUser) {
                usernameInput.value = savedUser;
                rememberMeCheckbox.checked = true;
            }

            loginForm.addEventListener('submit', (e) => {
                const user = usernameInput.value;
                if (rememberMeCheckbox.checked) {
                    localStorage.setItem('savedUsername', user);
                } else {
                    localStorage.removeItem('savedUsername');
                }
            });

            forgotPassLink.addEventListener('click', (e) => {
                e.preventDefault();
                const user = usernameInput.value;
                if(user) {
                    alert(`Password reset link sent to registered email for ID: ${user}`);
                } else {
                    alert("Please enter your Username first to reset password.");
                }
            });

            <?php if (!empty($login_error)): ?>
                alert("<?php echo addslashes($login_error); ?>");
            <?php endif; ?>
        });
    </script>

</body>
</html>