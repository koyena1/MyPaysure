<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'paysure_insurance');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_NAME', 'PaySure Insurance');
define('SITE_URL', 'http://localhost/paysure-insurance');
define('ADMIN_EMAIL', 'admin@paysure.com');

// Commission settings
define('DIRECT_COMMISSION', 40.00);
define('LEVEL1_COMMISSION', 10.00);
define('LEVEL2_COMMISSION', 6.00);
define('LEVEL3_COMMISSION', 4.00);

// File upload paths
define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('KYC_PATH', UPLOAD_PATH . 'kyc/');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>