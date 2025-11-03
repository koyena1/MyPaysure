<?php
class Auth {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // User registration
    public function registerDistributor($data, $sponsorId = null, $parentId = null) {
        // Validate required fields
        $required = ['first_name', 'last_name', 'email', 'phone', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return ['success' => false, 'message' => "{$field} is required"];
            }
        }
        
        // Validate email
        if (!validateEmail($data['email'])) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        // Check if email already exists
        if ($this->emailExists($data['email'])) {
            return ['success' => false, 'message' => 'Email already registered'];
        }
        
        // Check if phone already exists
        if ($this->phoneExists($data['phone'])) {
            return ['success' => false, 'message' => 'Phone number already registered'];
        }
        
        // Generate PIN and distributor code
        $pinNumber = generatePIN();
        $distributorCode = generateDistributorCode($data['first_name'] . ' ' . $data['last_name']);
        
        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        try {
            $this->db->beginTransaction();
            
            // Insert distributor
            $sql = "INSERT INTO distributors (
                parent_id, sponsor_id, pin_number, first_name, last_name, 
                email, phone, date_of_birth, gender, password, 
                kyc_document_type, kyc_document_number, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $params = [
                $parentId, $sponsorId, $pinNumber, 
                sanitizeInput($data['first_name']),
                sanitizeInput($data['last_name']),
                sanitizeInput($data['email']),
                sanitizeInput($data['phone']),
                !empty($data['date_of_birth']) ? $data['date_of_birth'] : null,
                !empty($data['gender']) ? $data['gender'] : null,
                $hashedPassword,
                !empty($data['kyc_document_type']) ? $data['kyc_document_type'] : null,
                !empty($data['kyc_document_number']) ? $data['kyc_document_number'] : null,
                'Unconfirmed'
            ];
            
            $this->db->query($sql, $params);
            $distributorId = $this->db->lastInsertId();
            
            // Add to network structure
            if ($parentId) {
                $this->addToNetwork($distributorId, $parentId, $sponsorId);
            }
            
            $this->db->commit();
            
            return [
                'success' => true, 
                'message' => 'Registration successful. Please complete KYC verification.',
                'distributor_id' => $distributorId,
                'pin_number' => $pinNumber
            ];
            
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Registration error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Registration failed. Please try again.'];
        }
    }
    
    // User login
    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Email and password are required'];
        }
        
        // Find user by email or phone
        $sql = "SELECT * FROM distributors WHERE (email = ? OR phone = ?) AND status = 'Confirmed'";
        $user = $this->db->fetch($sql, [$email, $email]);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid credentials or account not activated'];
        }
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }
        
        // Set session
        $this->setUserSession($user);
        
        // Update last login
        $this->updateLastLogin($user['distributor_id']);
        
        return ['success' => true, 'message' => 'Login successful'];
    }
    
    // Admin login
    public function adminLogin($username, $password) {
        // In a real application, you'd have an admin table
        // For demo purposes, using hardcoded admin credentials
        $adminUsername = 'admin';
        $adminPasswordHash = password_hash('admin123', PASSWORD_DEFAULT);
        
        if ($username === $adminUsername && password_verify($password, $adminPasswordHash)) {
            $_SESSION['user_id'] = 1;
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_name'] = 'Administrator';
            $_SESSION['logged_in'] = true;
            
            return ['success' => true, 'message' => 'Admin login successful'];
        }
        
        return ['success' => false, 'message' => 'Invalid admin credentials'];
    }
    
    // Set user session
    private function setUserSession($user) {
        Session::regenerate();
        
        $_SESSION['user_id'] = $user['distributor_id'];
        $_SESSION['user_role'] = 'distributor';
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_phone'] = $user['phone'];
        $_SESSION['pin_number'] = $user['pin_number'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
    }
    
    // Update last login
    private function updateLastLogin($distributorId) {
        $sql = "UPDATE distributors SET last_login = NOW() WHERE distributor_id = ?";
        $this->db->query($sql, [$distributorId]);
    }
    
    // Check if email exists
    private function emailExists($email) {
        $sql = "SELECT distributor_id FROM distributors WHERE email = ?";
        return $this->db->fetch($sql, [$email]) !== false;
    }
    
    // Check if phone exists
    private function phoneExists($phone) {
        $sql = "SELECT distributor_id FROM distributors WHERE phone = ?";
        return $this->db->fetch($sql, [$phone]) !== false;
    }
    
    // Add user to network structure
    private function addToNetwork($distributorId, $parentId, $sponsorId) {
        // Determine leg type (left or right)
        $sql = "SELECT COUNT(*) as count FROM network_structure WHERE parent_id = ? AND leg_type = 'Left'";
        $leftCount = $this->db->fetch($sql, [$parentId])['count'];
        
        $legType = ($leftCount % 2 == 0) ? 'Left' : 'Right';
        
        // Insert into network structure
        $sql = "INSERT INTO network_structure (distributor_id, parent_id, sponsor_id, leg_type) VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [$distributorId, $parentId, $sponsorId, $legType]);
        
        // Update parent's leg counts
        $updateField = $legType === 'Left' ? 'left_leg_count' : 'right_leg_count';
        $sql = "UPDATE distributors SET {$updateField} = {$updateField} + 1 WHERE distributor_id = ?";
        $this->db->query($sql, [$parentId]);
    }
    
    // Logout
    public function logout() {
        Session::destroy();
        return ['success' => true, 'message' => 'Logout successful'];
    }
    
    // Change password
    public function changePassword($userId, $currentPassword, $newPassword) {
        $sql = "SELECT password FROM distributors WHERE distributor_id = ?";
        $user = $this->db->fetch($sql, [$userId]);
        
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE distributors SET password = ? WHERE distributor_id = ?";
        $this->db->query($sql, [$hashedPassword, $userId]);
        
        return ['success' => true, 'message' => 'Password changed successfully'];
    }
}

// Initialize auth
$auth = new Auth($db);
?>