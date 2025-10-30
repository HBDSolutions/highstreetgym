<!-- Blog Content View -->
<div class="container mt-4">
    <h1 class="mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
    
    <!-- Success Message -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i>
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Create Post Section - Only if user has permission -->
    <?php if ($canCreatePost): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Share Your Experience</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/highstreetgym/controllers/content/blog_controller.php" id="createPostForm">
                    <input type="hidden" name="action" value="create_post">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Post Title <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" 
                            id="title" 
                            name="title" 
                            placeholder="Enter a catchy title (5-200 characters)"
                            value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                            required
                            minlength="5"
                            maxlength="200">
                        <?php if (isset($errors['title'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['title']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message <span class="text-danger">*</span></label>
                        <textarea 
                            class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>" 
                            id="message" 
                            name="message" 
                            rows="5" 
                            placeholder="Share your fitness journey, tips, or motivation (10-2000 characters)"
                            required
                            minlength="10"
                            maxlength="2000"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        <div class="form-text">
                            <span id="charCount">0</span> / 2000 characters
                        </div>
                        <?php if (isset($errors['message'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['message']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send"></i> Post Message
                    </button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle"></i> 
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a> or 
            <a href="/highstreetgym/controllers/content/auth/register_controller.php">Register</a> 
            to share your fitness journey with fellow members!
        </div>
    <?php endif; ?>
    
    <!-- Blog Posts Display -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">Recent Posts</h2>
            
            <?php if (empty($posts)): ?>
                <div class="alert alert-light text-center py-5">
                    <i class="bi bi-chat-left-text" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0">No blog posts yet. Be the first to share your experience!</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title h5"><?= htmlspecialchars($post['title']) ?></h3>
                            
                            <div class="text-muted small mb-3">
                                <i class="bi bi-person-circle"></i> 
                                Posted by <strong><?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></strong>
                                <span class="mx-2">|</span>
                                <i class="bi bi-calendar"></i> 
                                <?= date('F j, Y \a\t g:i A', strtotime($post['post_date'])) ?>
                            </div>
                            
                            <p class="card-text"><?= nl2br(htmlspecialchars($post['message'])) ?></p>
                            
                            <?php if ($post['can_edit'] || $post['can_delete']): ?>
                                <div class="mt-3">
                                    <?php if ($post['can_edit']): ?>
                                        <button class="btn btn-sm btn-outline-primary" disabled>
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($post['can_delete']): ?>
                                        <button class="btn btn-sm btn-outline-danger" disabled>
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Client-side JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageField = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    
    if (messageField && charCount) {
        // Update character count on input
        messageField.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            
            // Visual feedback for character limit
            if (this.value.length > 2000) {
                charCount.classList.add('text-danger');
            } else if (this.value.length > 1800) {
                charCount.classList.add('text-warning');
                charCount.classList.remove('text-danger');
            } else {
                charCount.classList.remove('text-warning', 'text-danger');
            }
        });
        
        // Initialise count
        charCount.textContent = messageField.value.length;
    }
    
    // Form validation
    const form = document.getElementById('createPostForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const message = document.getElementById('message').value.trim();
            
            // Client-side validation
            if (title.length < 5 || title.length > 200) {
                e.preventDefault();
                alert('Title must be between 5 and 200 characters.');
                return false;
            }
            
            if (message.length < 10 || message.length > 2000) {
                e.preventDefault();
                alert('Message must be between 10 and 2000 characters.');
                return false;
            }
        });
    }
});
</script>

<style>
/* Additional styling for blog posts */
article.card {
    transition: box-shadow 0.3s ease;
}

article.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-title {
    color: #2c5f2d;
    font-weight: 600;
}
</style>