<?php print_r($adminData); ?>
<?php foreach ($posts as $post): ?>
    <div><?= $post['title']; ?></div>
<?php endforeach; ?>
<div>
    <?php for ($p = 1; $p <= $pagesAmount; $p++): ?>
        <a href="?page=<?= $p; ?>"><span><?= $p; ?></span></a>
    <?php endfor; ?>
<div>