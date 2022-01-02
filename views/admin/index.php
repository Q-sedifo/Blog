<div>Index page</div>
<div>
    <strong>All posts: <?= $postsAmount; ?></strong>
    <?php foreach ($posts as $post): ?>
        <div><?= $post['title']; ?><a href="?controller=admin&action=editPost&id=<?= $post['id']; ?>"><</a><a href="#">&times;</a></div>
    <?php endforeach; ?>
</div>