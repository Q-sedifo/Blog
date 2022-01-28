<div>Index page</div>
<div>
    <strong>All posts: <span id="postCount"><?= $postsAmount; ?></span></strong>
    <?php foreach ($posts as $post): ?>
        <div id="post<?= $post['id'] ?>"><?= $post['title']; ?><a href="?controller=admin&action=editPost&id=<?= $post['id']; ?>"><</a><button onclick="deletePost(<?= $post['id']; ?>)">&times;</button></div>
    <?php endforeach; ?>
    <?php if ($postsAmount > 3): ?>
        <div>
            <?php for ($p = 1; $p <= $pagesAmount; $p++): ?>
                <a href="?controller=admin&page=<?= $p; ?>" style="<?php if ($_GET['page'] == $p): ?>color: red;<?php endif; ?>"><?= $p; ?></a>
            <?php endfor; ?>
        <div>
    <?php endif; ?>
</div>