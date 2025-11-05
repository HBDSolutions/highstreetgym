<?php
// QUICK TEST TO VERIFY LOGIN SYSTEM WORKS

require_once __DIR__ . '/models/database.php';
require_once __DIR__ . '/models/user_functions.php';

try {
    $conn = get_database_connection();
    
    // Test with Bob's credentials
    $email = 'bob.builder@highstreetgym.com.au';
    $password = 'password123';
    
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
        
        echo "\n✅ LOGIN SYSTEM: WORKING!\n";
    } else {
        echo "\n❌ LOGIN SYSTEM: FAILED!\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
?>