<?php
class Session {
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Set session variable
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    // Get session variable
    public static function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    // Check if session variable exists
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    // Remove session variable
    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    // Destroy entire session
    public static function destroy() {
        session_destroy();
        $_SESSION = array();
    }
    
    // Set flash message
    public static function setFlash($type, $message) {
        self::set('flash', ['type' => $type, 'message' => $message]);
    }
    
    // Get flash message
    public static function getFlash() {
        $flash = self::get('flash');
        self::remove('flash');
        return $flash;
    }
    
    // Check if user is logged in
    public static function isLoggedIn() {
        return self::has('user_id') && self::has('user_role');
    }
    
    // Check if user is admin
    public static function isAdmin() {
        return self::isLoggedIn() && self::get('user_role') === 'admin';
    }
    
    // Check if user is distributor
    public static function isDistributor() {
        return self::isLoggedIn() && self::get('user_role') === 'distributor';
    }
    
    // Regenerate session ID for security
    public static function regenerate() {
        session_regenerate_id(true);
    }
}

// Initialize session handler
$session = new Session();
?>