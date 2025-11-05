<?php
// SIMPLE DATABASE CONNECTION TEST

require_once __DIR__ . '/models/database.php';

try {
    $conn = get_database_connection();
    echo "Database connection: SUCCESS\n";
    
    // Test if users table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "Users table: EXISTS\n";
        
        // Test user count
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Users in database: " . $result['count'] . "\n";
        
        // Test specific user
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['bob.builder@righstreetgym.com.au']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "Test user found: " . $user['email'] . " (Type: " . $user['user_type'] . ")\n";
            echo "Password hash exists: " . (isset($user['password_hash']) ? 'YES' : 'NO') . "\n";
        } else {
            echo "Test user NOT FOUND\n";
        }
        
    } else {
        echo "Users table: NOT FOUND\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}