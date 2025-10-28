<?php

// BLOG MANAGEMENT FUNCTIONS


// Get all blog posts

function get_all_blog_posts($conn, $limit = null) {
    try {
        $sql = "SELECT 
                    p.post_id,
                    p.title,
                    p.message,
                    p.post_date,
                    u.user_id,
                    u.first_name,
                    u.last_name,
                    u.email
                FROM blog_posts p
                INNER JOIN users u ON p.user_id = u.user_id
                ORDER BY p.post_date DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $conn->prepare($sql);
        
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $posts;
        
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Get a single blog post by ID
 * 
 * @param PDO $conn Database connection
 * @param int $postId Post ID
 * @return array|null Blog post or null if not found
 */
function get_blog_post_by_id($conn, $postId) {
    try {
        $sql = "SELECT 
                    p.post_id,
                    p.title,
                    p.message,
                    p.post_date,
                    u.user_id,
                    u.first_name,
                    u.last_name,
                    u.email
                FROM blog_posts p
                INNER JOIN users u ON p.user_id = u.user_id
                WHERE p.post_id = :post_id
                LIMIT 1";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $post;
        
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Create a new blog post
 * BUSINESS LOGIC: Validates title and message content
 * 
 * @param PDO $conn Database connection
 * @param int $userId User ID creating the post
 * @param string $title Post title
 * @param string $message Post message/content
 * @return array ['success' => bool, 'message' => string, 'errors' => array]
 */
function create_blog_post($conn, $userId, $title, $message) {
    $errors = [];
    
    // BUSINESS RULE: Validate post data
    $errors = validate_blog_post_data($title, $message);
    
    if (!empty($errors)) {
        return [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ];
    }
    
    // Create the blog post
    try {
        $sql = "INSERT INTO blog_posts (user_id, title, message) 
                VALUES (:user_id, :title, :message)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':title', trim($title));
        $stmt->bindValue(':message', trim($message));
        $stmt->execute();
        $stmt->closeCursor();
        
        return [
            'success' => true,
            'message' => 'Blog post created successfully',
            'post_id' => $conn->lastInsertId()
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to create blog post',
            'errors' => ['database' => 'An error occurred. Please try again.']
        ];
    }
}

/**
 * Update an existing blog post
 * BUSINESS LOGIC: User can only update their own posts
 * 
 * @param PDO $conn Database connection
 * @param int $postId Post ID to update
 * @param int $userId User ID requesting the update
 * @param string $title New title
 * @param string $message New message
 * @return array ['success' => bool, 'message' => string, 'errors' => array]
 */
function update_blog_post($conn, $postId, $userId, $title, $message) {
    $errors = [];
    
    // BUSINESS RULE: Validate post data
    $errors = validate_blog_post_data($title, $message);
    
    if (!empty($errors)) {
        return [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ];
    }
    
    try {
        // BUSINESS RULE: Verify post belongs to user (or user is admin)
        $sql = "SELECT user_id FROM blog_posts WHERE post_id = :post_id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'errors' => ['post' => 'Blog post does not exist']
            ];
        }
        
        if ($post['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'Access denied',
                'errors' => ['permission' => 'You can only edit your own posts']
            ];
        }
        
        // Update the post
        $sql = "UPDATE blog_posts 
                SET title = :title, message = :message 
                WHERE post_id = :post_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', trim($title));
        $stmt->bindValue(':message', trim($message));
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        
        return [
            'success' => true,
            'message' => 'Blog post updated successfully'
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to update blog post',
            'errors' => ['database' => 'An error occurred. Please try again.']
        ];
    }
}

/**
 * Delete a blog post
 * BUSINESS LOGIC: User can only delete their own posts
 * 
 * @param PDO $conn Database connection
 * @param int $postId Post ID to delete
 * @param int $userId User ID requesting deletion
 * @return array ['success' => bool, 'message' => string]
 */
function delete_blog_post($conn, $postId, $userId) {
    try {
        // BUSINESS RULE: Verify post belongs to user
        $sql = "SELECT user_id FROM blog_posts WHERE post_id = :post_id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found'
            ];
        }
        
        if ($post['user_id'] != $userId) {
            return [
                'success' => false,
                'message' => 'You can only delete your own posts'
            ];
        }
        
        // Delete the post
        $sql = "DELETE FROM blog_posts WHERE post_id = :post_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        
        return [
            'success' => true,
            'message' => 'Blog post deleted successfully'
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to delete blog post'
        ];
    }
}

/**
 * Get posts by a specific user
 * 
 * @param PDO $conn Database connection
 * @param int $userId User ID
 * @return array Array of blog posts by this user
 */
function get_user_blog_posts($conn, $userId) {
    try {
        $sql = "SELECT 
                    p.post_id,
                    p.title,
                    p.message,
                    p.post_date,
                    u.user_id,
                    u.first_name,
                    u.last_name
                FROM blog_posts p
                INNER JOIN users u ON p.user_id = u.user_id
                WHERE p.user_id = :user_id
                ORDER BY p.post_date DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $posts;
        
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Validate blog post data
 * BUSINESS LOGIC: Title and message validation rules
 * 
 * @param string $title Post title
 * @param string $message Post message
 * @return array Errors array
 */
function validate_blog_post_data($title, $message) {
    $errors = [];
    
    // BUSINESS RULE: Title required, 5-200 characters
    if (empty($title)) {
        $errors['title'] = 'Title is required';
    } elseif (strlen(trim($title)) < 5) {
        $errors['title'] = 'Title must be at least 5 characters';
    } elseif (strlen(trim($title)) > 200) {
        $errors['title'] = 'Title must not exceed 200 characters';
    }
    
    // BUSINESS RULE: Message required, 10-2000 characters
    if (empty($message)) {
        $errors['message'] = 'Message is required';
    } elseif (strlen(trim($message)) < 10) {
        $errors['message'] = 'Message must be at least 10 characters';
    } elseif (strlen(trim($message)) > 2000) {
        $errors['message'] = 'Message must not exceed 2000 characters';
    }
    
    return $errors;
}
?>