<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "paysure_insurance";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// --- LOGIC TO FIND THE USER ID ---
$user_id = 0;

if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
} elseif (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
}

// If we still don't have an ID, stop.
if($user_id == 0) {
    die("<div style='text-align:center; margin-top:50px;'><h3>Access Denied.</h3><p>Please log in to your dashboard to view this letter.</p></div>");
}

// --- CHECK IF LETTER IS SENT ---
$check_sql = "SELECT * FROM users WHERE id = $user_id";
$check_result = $conn->query($check_sql);
$user_data = $check_result->fetch_assoc();

if (!$user_data) {
    die("User not found.");
}

// If admin hasn't clicked "Send" yet
if (!isset($user_data['welcome_letter_sent']) || $user_data['welcome_letter_sent'] == 0) {
    echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>
            <h2>Welcome Letter Pending</h2>
            <p>Your welcome letter is currently being generated.</p>
            <a href='user_panel.php'>Return to Dashboard</a>
          </div>";
    exit();
}

// Fetch Letter Content
$letter_res = $conn->query("SELECT * FROM welcome_letter_settings WHERE id=1");
$letter = ($letter_res->num_rows > 0) ? $letter_res->fetch_assoc() : [
    'header_title' => 'PAYSURE', 'tagline' => 'Caring For Your Life',
    'greeting_text' => 'Dear Partner,', 'intro_paragraph' => 'Welcome...',
    'highlight_text' => 'Highlights...', 'step_section_title' => 'Steps',
    'footer_text' => 'PaySure Team',
    'address' => '' 
];

$display_greeting = "Dear " . htmlspecialchars($user_data['full_name']) . ",";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PaySure</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; color: #333; }
        .letter-container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-top: 6px solid #0056b3; }
        .header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .logo-placeholder { width: 60px; height: 60px; background: #0056b3; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-bottom: 10px; }
        h1 { color: #0056b3; margin: 0; font-size: 28px; }
        .tagline { color: #0099cc; font-style: italic; }
        .greeting { font-size: 18px; font-weight: bold; color: #0056b3; margin-bottom: 15px; }
        .highlights { background: #f8f9fa; border-left: 4px solid #0099cc; padding: 15px; font-style: italic; margin: 20px 0; }
        .steps { background: #eaf4ff; padding: 20px; border-radius: 8px; }
        .cta { display: block; width: 200px; margin: 30px auto; text-align: center; background: #0056b3; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; font-size: 13px; color: #888; border-top: 1px solid #eee; margin-top: 40px; padding-top: 20px; }
        .meta-info { margin-bottom: 20px; font-size: 14px; color: #555; }
        .meta-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .user-address { margin-top: 5px; font-style: italic; color: #666; }
    </style>
</head>
<body>

<div class="letter-container">
    <div class="header">
        <div class="logo-placeholder">PS</div>
        <h1><?php echo htmlspecialchars($letter['header_title']); ?></h1>
        <div class="tagline"><?php echo htmlspecialchars($letter['tagline']); ?></div>
    </div>

    <div class="meta-info">
        <div class="meta-row">
            <span><strong>Date:</strong> <?php echo date("F j, Y"); ?></span>
            <span><strong>Member ID:</strong> <?php echo htmlspecialchars($user_data['username']); ?></span>
        </div>
        
        <?php if(!empty($user_data['address'])): ?>
            <div class="user-address">
                <strong>Address:</strong> <?php echo htmlspecialchars($user_data['address']); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="greeting"><?php echo $display_greeting; ?></div>

    <p><?php echo nl2br(htmlspecialchars($letter['intro_paragraph'])); ?></p>

    <div class="highlights">"<?php echo nl2br(htmlspecialchars($letter['highlight_text'])); ?>"</div>

    <div class="steps">
        <h3 style="color:#004494; margin-top:0; border-bottom:1px solid #ccc; padding-bottom:10px;">
            <?php echo htmlspecialchars($letter['step_section_title']); ?>
        </h3>
        <p>Please complete these steps:</p>
        <ul>
            <li>Registration & KYC</li>
            <li>Product Selection</li>
            <li>Activation</li>
        </ul>
    </div>

    <p>We look forward to helping you grow your wealth.</p>

    <div style="margin-top:30px;">
        <p>Sincerely,</p>
        <p><strong>The PaySure Team</strong></p>
    </div>

    <a href="user_panel.php" class="cta">Proceed to Dashboard</a>

    <div class="footer">
        <p><?php echo htmlspecialchars($letter['footer_text']); ?></p>
        
        <?php if(!empty($letter['address'])): ?>
            <p><?php echo htmlspecialchars($letter['address']); ?></p>
        <?php endif; ?>

        <p>&copy; <?php echo date("Y"); ?> PaySure. All rights reserved.</p>
    </div>
</div>

</body>
</html>