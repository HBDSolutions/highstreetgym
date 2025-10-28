<?php

// USER MANAGEMENT FUNCTIONS


// Register a new user

function register_user($conn, $data) {
    $errors = [];
    
    // Validate required fields
    $errors = validate_registration_data($data);
    
    if (!empty($errors)) {
        return [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ];
    }
    
    // Check if email is already registered
    if (!is_email_unique($conn, $data['email'])) {
        return [
            'success' => false,
            'message' => 'Email already registered',
            'errors' => ['email' => 'This email is already registered']
        ];
    }
    
    // Hash password securely
    $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Insert user into database
    try {
        $sql = "INSERT INTO users 
                (first_name, last_name, email, password_hash, phone, user_type, status) 
                VALUES (:first_name, :last_name, :email, :password_hash, :phone, 'member', 'active')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':first_name', trim($data['first_name']));
        $stmt->bindValue(':last_name', trim($data['last_name']));
        $stmt->bindValue(':email', strtolower(trim($data['email'])));
        $stmt->bindValue(':password_hash', $passwordHash);
        $stmt->bindValue(':phone', trim($data['phone'] ?? ''));
        $stmt->execute();
        $stmt->closeCursor();
        
        return [
            'success' => true,
            'message' => 'Registration successful',
            'user_id' => $conn->lastInsertId()
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Database error',
            'errors' => ['database' => 'Registration failed. Please try again.']
        ];
    }
}

// Authenticate user login

function login_user($conn, $email, $password) {
    
    // Validate input
    if (empty($email) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Email and password are required',
            'user' => null
        ];
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Invalid email format',
            'user' => null
        ];
    }
    
    // Get user from database
    try {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', strtolower(trim($email)));
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        // Check if user exists
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid email or password',
                'user' => null
            ];
        }
        
        // Check if user is active
        if ($user['status'] !== 'active') {
            return [
                'success' => false,
                'message' => 'Account is inactive. Please contact support.',
                'user' => null
            ];
        }
        
        // Verify password
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

// Validate registration data

function validate_registration_data($data) {
    $errors = [];
    
    // First name required, 2-50 characters
    if (empty($data['first_name'])) {
        $errors['first_name'] = 'First name is required';
    } elseif (strlen(trim($data['first_name'])) < 2 || strlen(trim($data['first_name'])) > 50) {
        $errors['first_name'] = 'First name must be 2-50 characters';
    }
    
    // Last name required, 2-50 characters
    if (empty($data['last_name'])) {
        $errors['last_name'] = 'Last name is required';
    } elseif (strlen(trim($data['last_name'])) < 2 || strlen(trim($data['last_name'])) > 50) {
        $errors['last_name'] = 'Last name must be 2-50 characters';
    }
    
    // Valid email required
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    } elseif (strlen($data['email']) > 100) {
        $errors['email'] = 'Email must not exceed 100 characters';
    }
    
    // Password strength requirements
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required';
    } else {
        $passwordError = validate_password_strength($data['password']);
        if (!empty($passwordError)) {
            $errors['password'] = $passwordError;
        }
    }
    
    // Password confirmation must match
    if (empty($data['password_confirm'])) {
        $errors['password_confirm'] = 'Please confirm your password';
    } elseif ($data['password'] !== $data['password_confirm']) {
        $errors['password_confirm'] = 'Passwords do not match';
    }
    
    // Phone must be valid format if provided
    if (!empty($data['phone'])) {
        $phone = preg_replace('/[^0-9]/', '', $data['phone']);
        if (strlen($phone) < 10 || strlen($phone) > 15) {
            $errors['phone'] = 'Invalid phone number format';
        }
    }
    
    return $errors;
}

// Validate password strength

function validate_password_strength($password) {
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

// Check if email is unique

function is_email_unique($conn, $email) {
    try {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', strtolower(trim($email)));
        $stmt->execute();
        $count = $stmt->fetchColumn();
        $stmt->closeCursor();
        
        return $count == 0;
        
    } catch (PDOException $e) {
        return false;
    }
}

// Get user by ID

function get_user_by_id($conn, $userId) {
    try {
        $sql = "SELECT user_id, first_name, last_name, email, phone, user_type, status, created_at 
                FROM users 
                WHERE user_id = :user_id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $user;
        
    } catch (PDOException $e) {
        return null;
    }
}

// Get user by email

function get_user_by_email($conn, $email) {
    try {
        $sql = "SELECT user_id, first_name, last_name, email, phone, user_type, status, created_at 
                FROM users 
                WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', strtolower(trim($email)));
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $user;
        
    } catch (PDOException $e) {
        return null;
    }
}
?>