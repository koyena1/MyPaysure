<?php
// Security functions
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone($phone) {
    return preg_match('/^[6-9]\d{9}$/', $phone);
}

function validatePAN($pan) {
    return preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', $pan);
}

function generatePIN($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pin = '';
    for ($i = 0; $i < $length; $i++) {
        $pin .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $pin;
}

function generateDistributorCode($name) {
    $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
    $random = rand(1000, 9999);
    return $prefix . $random;
}

// Formatting functions
function formatCurrency($amount) {
    return '₹' . number_format($amount, 2);
}

function formatDate($date, $format = 'd-m-Y') {
    if (empty($date)) return '';
    $datetime = new DateTime($date);
    return $datetime->format($format);
}

function formatDateTime($datetime, $format = 'd-m-Y H:i:s') {
    if (empty($datetime)) return '';
    $dt = new DateTime($datetime);
    return $dt->format($format);
}

// Commission calculation functions
function calculateDirectCommission($premiumAmount) {
    return ($premiumAmount * DIRECT_COMMISSION) / 100;
}

function calculateLevelCommission($premiumAmount, $level) {
    $rates = [
        1 => LEVEL1_COMMISSION,
        2 => LEVEL2_COMMISSION,
        3 => LEVEL3_COMMISSION
    ];
    
    if (isset($rates[$level])) {
        return ($premiumAmount * $rates[$level]) / 100;
    }
    return 0;
}

function calculatePerformanceBonus($leftBusiness, $rightBusiness) {
    $matchingPairs = min($leftBusiness, $rightBusiness) / 50000; // Each unit = ₹50,000
    return $matchingPairs * PERFORMANCE_BONUS;
}

function calculatePromotionalBonus($premiumAmount) {
    return ($premiumAmount * PROMOTIONAL_BONUS_RATE) / 100;
}

// Network functions
function getNetworkLevel($distributorId, $targetId, $currentLevel = 1, $maxLevel = 10) {
    if ($currentLevel > $maxLevel) return 0;
    
    global $db;
    $sql = "SELECT parent_id FROM network_structure WHERE distributor_id = ?";
    $parent = $db->fetch($sql, [$targetId]);
    
    if ($parent && $parent['parent_id'] == $distributorId) {
        return $currentLevel;
    } elseif ($parent && $parent['parent_id'] != 0) {
        return getNetworkLevel($distributorId, $parent['parent_id'], $currentLevel + 1, $maxLevel);
    }
    
    return 0;
}

// File upload function
function uploadFile($file, $uploadPath, $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }
    
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowedTypes)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    // Generate unique filename
    $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
    $filePath = $uploadPath . $fileName;
    
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return ['success' => true, 'filename' => $fileName, 'filepath' => $filePath];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

// Redirect function
function redirect($url, $statusCode = 303) {
    header('Location: ' . $url, true, $statusCode);
    exit();
}

// CSRF token functions
function getCSRFToken() {
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Error and success message handling
function addMessage($type, $message) {
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    $_SESSION['messages'][] = ['type' => $type, 'message' => $message];
}

function getMessages() {
    $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
    unset($_SESSION['messages']);
    return $messages;
}

// Check if it's AJAX request
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Get client IP address
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
?>