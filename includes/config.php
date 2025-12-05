<?php
// Database configuration
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'paysure_insurance');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');

// Site configuration
if (!defined('SITE_NAME')) define('SITE_NAME', 'PaySure Insurance');
if (!defined('SITE_URL')) define('SITE_URL', 'http://localhost/paysure-insurance');
if (!defined('SITE_PATH')) define('SITE_PATH', __DIR__ . '/../');
if (!defined('ADMIN_EMAIL')) define('ADMIN_EMAIL', 'admin@paysure.com');

// Commission settings
if (!defined('DIRECT_COMMISSION')) define('DIRECT_COMMISSION', 40.00);
if (!defined('LEVEL1_COMMISSION')) define('LEVEL1_COMMISSION', 10.00);
if (!defined('LEVEL2_COMMISSION')) define('LEVEL2_COMMISSION', 6.00);
if (!defined('LEVEL3_COMMISSION')) define('LEVEL3_COMMISSION', 4.00);
if (!defined('PERFORMANCE_BONUS')) define('PERFORMANCE_BONUS', 2000.00);
if (!defined('PROMOTIONAL_BONUS_RATE')) define('PROMOTIONAL_BONUS_RATE', 6.00);

// File upload paths
if (!defined('UPLOAD_PATH')) define('UPLOAD_PATH', SITE_PATH . 'uploads/');
if (!defined('KYC_PATH')) define('KYC_PATH', UPLOAD_PATH . 'kyc/');
if (!defined('PROFILE_PATH')) define('PROFILE_PATH', UPLOAD_PATH . 'profile/');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    // Only set params if cookies haven't been sent yet
    if (!headers_sent()) {
        session_set_cookie_params([
            'lifetime' => 86400,
            'path' => '/',
            'domain' => '',
            'secure' => false, 
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
    session_start();
}

// CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --- DATABASE CONNECTION (Fixes the $conn error) ---
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>