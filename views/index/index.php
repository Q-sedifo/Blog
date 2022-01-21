<?php print_r($adminData); ?>
<?php if ($posts): ?>
    <?php foreach ($posts as $post): ?>
        <div><?= $post['title']; ?><a href="?action=post&id=<?= $post['id']; ?>">></a></div>
    <?php endforeach; ?>
    <?php if ($postsAmount > 3): ?>
        <div>
            <?php for ($p = 1; $p <= $pagesAmount; $p++): ?>
                <a href="?page=<?= $p; ?>"><?= $p; ?></a>
            <?php endfor; ?>
        <div>
    <?php endif; ?>
<?php else: ?>
    <div>No posts</div>
<?php endif; ?>
<?php if (!isset($_SESSION['admin'])): ?>
    <a href="?action=login">Login</a>
<?php else: ?>
    <a href="?controller=admin">Admin panel</a>
<?php endif; ?>
<a href="?action=contact">Feedback</a>
