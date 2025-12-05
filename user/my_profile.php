<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'user') { 
    header("Location: ../login.php"); 
    exit; 
}

include '../includes/db.php';
$member_id = $_SESSION['username'];

// 2. Fetch Profile Data
$stmt = $db->prepare("SELECT * FROM user_profiles WHERE member_id = ?");
$stmt->execute([$member_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle case where profile might not exist yet to prevent PHP warnings
if (!$profile) {
    $profile = [];
}

// Helper to get initials for the avatar (e.g., "John Doe" -> "JD")
$fullName = $profile['full_name'] ?? $_SESSION['full_name'] ?? 'User';
$words = explode(" ", $fullName);
$initials = "";
foreach ($words as $w) {
    $initials .= mb_substr($w, 0, 1);
}
// Limit to 2 chars
$initials = substr($initials, 0, 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* --- 1. Global Reset & Animated Background --- */
        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            /* Animated Gradient Background */
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #2d3748;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* --- 2. The Glass Card --- */
        .card-box {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.85); /* Translucent White */
            backdrop-filter: blur(12px); /* The "Frosted Glass" effect */
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.4);
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeIn {
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- 3. Header & Avatar --- */
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 35px;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 28px;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
            margin-bottom: 15px;
        }

        h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: #1a202c;
        }

        .subtitle {
            font-size: 14px;
            color: #718096;
            margin-top: 5px;
        }

        /* --- 4. Profile List Items --- */
        .profile-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .profile-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            
            /* Animation Setup */
            opacity: 0;
            animation: slideIn 0.5s ease-out forwards;
        }

        .profile-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-color: #e2e8f0;
        }

        .label {
            font-size: 0.85rem;
            color: #a0aec0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .value {
            font-size: 0.95rem;
            color: #2d3748;
            font-weight: 500;
            text-align: right;
            word-break: break-word; /* Prevents long emails from breaking layout */
        }

        /* --- 5. Staggered Animation Delays --- */
        .profile-item:nth-child(1) { animation-delay: 0.1s; }
        .profile-item:nth-child(2) { animation-delay: 0.2s; }
        .profile-item:nth-child(3) { animation-delay: 0.3s; }
        .profile-item:nth-child(4) { animation-delay: 0.4s; }
        .profile-item:nth-child(5) { animation-delay: 0.5s; }
        .profile-item:nth-child(6) { animation-delay: 0.6s; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* --- 6. Mobile Responsiveness --- */
        @media (max-width: 480px) {
            .card-box {
                padding: 30px 20px;
            }

            .profile-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .value {
                text-align: left;
                width: 100%;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="card-box">
    
    <div class="profile-header">
        <div class="avatar-circle">
            <?php echo htmlspecialchars($initials); ?>
        </div>
        <h3><?php echo htmlspecialchars($fullName); ?></h3>
        <div class="subtitle">Member Profile</div>
    </div>
    
    <div class="profile-list">
        <div class="profile-item">
            <span class="label">Full Name</span>
            <span class="value"><?php echo htmlspecialchars($fullName); ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Email</span>
            <span class="value"><?php echo htmlspecialchars($profile['email'] ?? 'Not Updated'); ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Mobile</span>
            <span class="value"><?php echo htmlspecialchars($profile['mobile'] ?? 'Not Updated'); ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Address</span>
            <span class="value"><?php echo htmlspecialchars($profile['address'] ?? 'Not Updated'); ?></span>
        </div>

        <div class="profile-item">
            <span class="label">PAN No</span>
            <span class="value"><?php echo htmlspecialchars($profile['pan_no'] ?? 'Not Updated'); ?></span>
        </div>

        <div class="profile-item">
            <span class="label">Aadhar No</span>
            <span class="value"><?php echo htmlspecialchars($profile['aadhar_no'] ?? 'Not Updated'); ?></span>
        </div>
    </div>
</div>

</body>
</html>