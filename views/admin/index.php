<div>Index page</div>
<div>
    <strong>All posts: <?= $postsAmount; ?></strong>
    <?php foreach ($posts as $post): ?>
        <div><?= $post['title']; ?><a href="?controller=admin&action=editPost&id=<?= $post['id']; ?>"><</a><a href="#">&times;</a></div>
    <?php endforeach; ?>
    <?php if ($postsAmount > 3): ?>
        <div>
            <?php for ($p = 1; $p <= $pagesAmount; $p++): ?>
                <a href="?controller=admin&page=<?= $p; ?>" style="<?php if ($_GET['page'] == $p): ?>color: red;<?php endif; ?>"><?= $p; ?></a>
            <?php endfor; ?>
        <div>
    <?php endif; ?>
</div>