<?php if (!isset($_SESSION['admin'])): ?>
    <a href="?action=login">Login</a>
<?php else: ?>
    <a href="?controller=admin">Admin panel</a>
<?php endif; ?>
<a href="?action=contact">Feedback</a>
<?php print_r($adminData); ?>
<div id="posts">
<?php if ($posts): ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <a href="?action=post&id=<?= $post['id']; ?>"><?= $post['title']; ?></a>
        </div>
    <?php endforeach; ?>
</div>
    <?php if ($postsAmount > 3): ?>
        <div>
            <button type="button" onclick="loadMorePosts()">More</button>
        </div>
    <?php endif; ?>
    <!-- Pagination -->
<?php else: ?>
    <div>No posts</div>
<?php endif; ?>

