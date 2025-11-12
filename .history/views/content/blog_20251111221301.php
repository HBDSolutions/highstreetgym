<!-- Blog Content View -->
<section class="container my-4">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    
    <?php if ($showSuccessMessage): ?>
        <?php include __DIR__ . '/../partials/messages/success.php'; ?>
    <?php endif; ?>
    
    <?php if ($showErrors): ?>
        <?php include __DIR__ . '/../partials/messages/errors.php'; ?>
    <?php endif; ?>
    
    <?php if ($showCreateForm): ?>
        <?php include __DIR__ . '/../partials/blog/blog_form.php'; ?>
    <?php endif; ?>
    
    <?php if ($showLoginPrompt): ?>
        <?php include __DIR__ . '/../partials/blog/blog_login.php'; ?>
    <?php endif; ?>
    
    <section class="mt-4">
        <h2>Recent Posts</h2>
        
        <?php if ($showNoPosts): ?>
            <?php include __DIR__ . '/../partials/blog/no_blogs.php'; ?>
        <?php endif; ?>
        
        <?php if ($showPosts): ?>
            <?php include __DIR__ . '/../partials/blog/blog_posts.php'; ?>
        <?php endif; ?>
    </section>
</section>