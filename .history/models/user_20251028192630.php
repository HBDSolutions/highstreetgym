<?php
// Handles user registration, authentication, and validation

class User {
    private $conn;
    private $table = 'users';
    
    function __construct() {
        // Get database connection
        require_once __DIR__ . '/database.php';
        $this->conn = $conn;
    }
    
    // Register a new user
   
    function register($data) {
        $errors = [];
        
        // Validate required fields
        $errors = array_merge($errors, $this->validateRegistrationData($data));
        
        if (!empty($errors)) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ];
        }
        
        // BUSINESS RULE: Check if email is already registered
        if (!$this->isEmailUnique($data['email'])) {
            return [
                'success' => false,
                'message' => 'Email already registered',
                'errors' => ['email' => 'This email is already registered']
            ];
        }
        
        // BUSINESS RULE: Hash password securely
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Insert user into database
        try {
            $sql = "INSERT INTO {$this->table} 
                    (first_name, last_name, email, password_hash, phone, user_type, status) 
                    VALUES (:first_name, :last_name, :email, :password_hash, :phone, 'member', 'active')";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':first_name' => trim($data['first_name']),
                ':last_name' => trim($data['last_name']),
                ':email' => strtolower(trim($data['email'])),
                ':password_hash' => $passwordHash,
                ':phone' => trim($data['phone'] ?? '')
            ]);
            
            return [
                'success' => true,
                'message' => 'Registration successful',
                'user_id' => $this->conn->lastInsertId()
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error',
                'errors' => ['database' => 'Registration failed. Please try again.']
            ];
        }
    }
    
    /**
     * Authenticate user login
     * BUSINESS LOGIC: Validates credentials, checks account status
     * 
     * @param string $email User email
     * @param string $password User password
     * @return array ['success' => bool, 'message' => string, 'user' => array|null]
     */
    function login($email, $password) {
        // BUSINESS RULE: Validate input
        if (empty($email) || empty($password)) {
            return [
                'success' => false,
                'message' => 'Email and password are required',
                'user' => null
            ];
        }
        
        // BUSINESS RULE: Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format',
                'user' => null
            ];
        }
        
        try {
            // Get user from database
            $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => strtolower(trim($email))]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // BUSINESS RULE: Check if user exists
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password',
                    'user' => null
                ];
            }
            
            // BUSINESS RULE: Check if account is active
            if ($user['status'] !== 'active') {
                return [
                    'success' => false,
                    'message' => 'Account is inactive. Please contact support.',
                    'user' => null
                ];
            }
            
            // BUSINESS RULE: Verify password
            if (!password_verify($password, $user['password_hash'])) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password',
                    'user' => null
                ];
            }
            
            // Remove password hash before returning user data
            unset($user['password_hash']);
            
            return [
                'success' => true,
                'message' => 'Login successful',
                'user' => $user
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error',
                'user' => null
            ];
        }
    }
    
    /**
     * Validate registration data
     * BUSINESS LOGIC: All validation rules for user registration
     * 
     * @param array $data Registration data
     * @return array Errors array
     */
    function validateRegistrationData($data) {
        $errors = [];
        
        // BUSINESS RULE: First name required, 2-50 characters
        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        } elseif (strlen(trim($data['first_name'])) < 2 || strlen(trim($data['first_name'])) > 50) {
            $errors['first_name'] = 'First name must be 2-50 characters';
        }
        
        // BUSINESS RULE: Last name required, 2-50 characters
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        } elseif (strlen(trim($data['last_name'])) < 2 || strlen(trim($data['last_name'])) > 50) {
            $errors['last_name'] = 'Last name must be 2-50 characters';
        }
        
        // BUSINESS RULE: Valid email required
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } elseif (strlen($data['email']) > 100) {
            $errors['email'] = 'Email must not exceed 100 characters';
        }
        
        // BUSINESS RULE: Password strength requirements
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } else {
            $passwordErrors = $this->validatePasswordStrength($data['password']);
            if (!empty($passwordErrors)) {
                $errors['password'] = $passwordErrors;
            }
        }
        
        // BUSINESS RULE: Password confirmation must match
        if (empty($data['password_confirm'])) {
            $errors['password_confirm'] = 'Please confirm your password';
        } elseif ($data['password'] !== $data['password_confirm']) {
            $errors['password_confirm'] = 'Passwords do not match';
        }
        
        // BUSINESS RULE: Phone optional, but if provided must be valid format
        if (!empty($data['phone'])) {
            $phone = preg_replace('/[^0-9]/', '', $data['phone']);
            if (strlen($phone) < 10 || strlen($phone) > 15) {
                $errors['phone'] = 'Invalid phone number format';
            }
        }
        
        return $errors;
    }
    
    /**
     * Validate password strength
     * BUSINESS RULE: Password must be at least 8 characters with uppercase, lowercase, number
     * 
     * @param string $password Password to validate
     * @return string Error message or empty string if valid
     */
    function validatePasswordStrength($password) {
        if (strlen($password) < 8) {
            return 'Password must be at least 8 characters';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            return 'Password must contain at least one uppercase letter';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            return 'Password must contain at least one lowercase letter';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            return 'Password must contain at least one number';
        }
        
        return '';
    }
    
    /**
     * Check if email is unique
     * BUSINESS RULE: Email must be unique in the system
     * 
     * @param string $email Email to check
     * @return bool True if unique, false if already exists
     */
    function isEmailUnique($email) {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => strtolower(trim($email))]);
            $count = $stmt->fetchColumn();
            
            return $count == 0;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Get user by ID
     * 
     * @param int $userId User ID
     * @return array|null User data or null if not found
     */
    function getUserById($userId) {
        try {
            $sql = "SELECT user_id, first_name, last_name, email, phone, user_type, status, created_at 
                    FROM {$this->table} 
                    WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            return null;
        }
    }
}
?>