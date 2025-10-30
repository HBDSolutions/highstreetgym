<!-- Blog Posts List Partial -->
<?php foreach ($posts as $post): ?>
    <article class="card mb-3">
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
            <p class="text-muted">
                Posted by <strong><?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></strong>
                on <?= date('F j, Y', strtotime($post['post_date'])) ?>
            </p>
            <p class="card-text"><?= nl2br(htmlspecialchars($post['message'])) ?></p>
        </div>
    </article>
<?php endforeach; ?>