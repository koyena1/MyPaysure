<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'paysure_insurance');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_NAME', 'PaySure Insurance');
define('SITE_URL', 'http://localhost/paysure-insurance');
define('SITE_PATH', __DIR__ . '/../');
define('ADMIN_EMAIL', 'admin@paysure.com');

// Commission settings (as per PDF)
define('DIRECT_COMMISSION', 40.00);
define('LEVEL1_COMMISSION', 10.00);
define('LEVEL2_COMMISSION', 6.00);
define('LEVEL3_COMMISSION', 4.00);
define('PERFORMANCE_BONUS', 2000.00);
define('PROMOTIONAL_BONUS_RATE', 6.00);

// File upload paths
define('UPLOAD_PATH', SITE_PATH . 'uploads/');
define('KYC_PATH', UPLOAD_PATH . 'kyc/');
define('PROFILE_PATH', UPLOAD_PATH . 'profile/');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Start session in a secure way
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400,
        'path' => '/',
        'domain' => '',
        'secure' => false, // Set to true in production with HTTPS
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>