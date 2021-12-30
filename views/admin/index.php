<div>Index page</div>
<div>
    <strong>All posts:</strong>
    <?php foreach ($posts as $post): ?>
        <div><?= $post['title']; ?><a href="?controller=admin&action=editPost"> <</a></div>
    <?php endforeach; ?>
</div>