<?php
// CHECK EXISTING USERS

require_once __DIR__ . '/models/database.php';

try {
    $conn = get_database_connection();
    
    // Get all users
    $stmt = $conn->query("SELECT user_id, email, user_type, status FROM users ORDER BY user_id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($users) . " users:\n";
    echo "====================\n";
    
    foreach ($users as $user) {
        echo "ID: " . $user['user_id'] . " | Email: " . $user['email'] . " | Type: " . $user['user_type'] . " | Status: " . $user['status'] . "\n";
    }
    
    // Check for bob.builder specifically
    echo "\nLooking for bob.builder variants:\n";
    $stmt = $conn->prepare("SELECT * FROM users WHERE email LIKE '%bob.builder%'");
    $stmt->execute();
    $bobUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($bobUsers) {
        foreach ($bobUsers as $user) {
            echo "FOUND: " . $user['email'] . " (Type: " . $user['user_type'] . ")\n";
        }
    } else {
        echo "NO bob.builder users found\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}