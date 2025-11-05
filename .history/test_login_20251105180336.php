<?php
// TEST LOGIN FUNCTION

require_once __DIR__ . '/models/database.php';
require_once __DIR__ . '/models/user_functions.php';

try {
    $conn = get_database_connection();
    
    // Test with the correct email
    $email = 'bob.builder@highstreetgym.com.au';
    $password = 'password123'; // Assuming this is the password
    
    echo "Testing login for: " . $email . "\n";
    echo "==========================================\n";
    
    $result = login_user($conn, $email, $password);
    
    echo "Login result:\n";
    echo "Success: " . ($result['success'] ? 'YES' : 'NO') . "\n";
    echo "Message: " . $result['message'] . "\n";
    
    if ($result['success'] && $result['user']) {
        echo "User data returned:\n";
        echo "- User ID: " . $result['user']['user_id'] . "\n";
        echo "- Email: " . $result['user']['email'] . "\n";
        echo "- User Type: " . $result['user']['user_type'] . "\n";
        echo "- First Name: " . $result['user']['first_name'] . "\n";
        echo "- Last Name: " . $result['user']['last_name'] . "\n";
        echo "- Status: " . $result['user']['status'] . "\n";
    }
    
    // Also test password verification manually
    echo "\n==========================================\n";
    echo "Manual password check:\n";
    
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "Password hash found: YES\n";
        echo "Password verification: " . (password_verify($password, $user['password_hash']) ? 'PASS' : 'FAIL') . "\n";
    } else {
        echo "User not found\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}