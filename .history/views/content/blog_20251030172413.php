<!-- Blog Content View - PURE PRESENTATION, NO LOGIC -->
<main>
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    
    <?= $messagesHTML ?>
    
    <?= $createFormHTML ?>
    
    <section>
        <h2>Recent Posts</h2>
        <?= $postsHTML ?>
    </section>
</main>