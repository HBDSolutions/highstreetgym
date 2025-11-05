<?php
// RESET BOB'S PASSWORD

require_once __DIR__ . '/models/database.php';

try {
    $conn = get_database_connection();
    
    // Set new password
    $newPassword = 'password123';
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Update Bob's password
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
    $result = $stmt->execute([$passwordHash, 'bob.builder@highstreetgym.com.au']);
    
    if ($result && $stmt->rowCount() > 0) {
        echo "✅ SUCCESS: Bob's password has been reset to 'password123'\n";
        echo "Email: bob.builder@highstreetgym.com.au\n";
        echo "Password: password123\n";
        
        // Test the new password immediately
        echo "\n🧪 Testing new password...\n";
        
        require_once __DIR__ . '/models/user_functions.php';
        $loginResult = login_user($conn, 'bob.builder@highstreetgym.com.au', 'password123');
        
        if ($loginResult['success']) {
            echo "✅ LOGIN TEST: SUCCESS!\n";
            echo "User Type: " . $loginResult['user']['user_type'] . "\n";
        } else {
            echo "❌ LOGIN TEST: FAILED - " . $loginResult['message'] . "\n";
        }
        
    } else {
        echo "❌ FAILED: Could not update password\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}