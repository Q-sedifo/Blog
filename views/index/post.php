<div><?= $post['title']; ?></div>
<div><?= $post['descript']; ?></div>
<div><?= $post['preview']; ?></div>
<div><?= $post['datatime']; ?></div>
<form method="POST" action="">
    <div>
        <input type="text" name="name" placeholder="Name">
    </div>
    <div>
        <input type="text" name="text" placeholder="Text">
    </div>
    <div>
        <input type="submit" value="Comment">
    </div>
</form>
<div>Comments:</div>
<?php foreach ($comments as $comment): ?>
    <div><?php print_r($comment); ?></div>
<?php endforeach; ?>
<div>Recomended posts:</div>
<?php print_r($recomendedPosts); ?>