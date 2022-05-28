<div class="preview" style="background: linear-gradient(rgba(0, 0, 0, 0) 50%, rgba(43, 47, 69, 1) 100%), url(<?= $adminData['background']; ?>);">
    <div class="avatar">
        <img src="<?= $adminData['ava']; ?>">
    </div>
    <div class="name"><?= $adminData['name']; ?></div>
</div>
<div id="posts" class="posts-section">
    <div class="row">
        <a href="#contact"><button class="btn">Contact me</button></a>
        <a href="#bio"><button class="btn">About me</button></a>
    </div>
    <div class="center"><img src="public/icons/list.svg"><?= $postsAmount; ?></div>
    <div class="title">Recent posts<img src="public/icons/history.svg"></div>
    <?php if ($posts): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <div class="card-title"><?= $post['title']; ?></div>
                <div class="card-preview" style="background: linear-gradient(rgba(20, 20, 20, .7) 0%, rgba(0, 0, 0, 0) 40%), url(<?= $post['mini_preview']; ?>);"></div>
                <div class="card-date"><?= $post['datatime']; ?></div>
                <a href="?action=post&id=<?= $post['id']; ?>"></a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="normal-message">No posts</div>
    <?php endif; ?>
</div>
<!-- Pagination -->
<?php if ($postsAmount > 3): ?>
    <div class="center line">
        <button class="btn" type="button" onclick="loadMorePosts(this)">More</button>
    </div>
<?php endif; ?>
<!-- Recomended posts -->
<?php require_once 'views/components/recomendedPostsSection.php'; ?>
<!-- Bio -->
<div id="bio" class="bio-section container">
    <div class="title">Bio<img src="public/icons/badge.svg"></div>
    <div><?= $adminData['bio']; ?></div>
</div>
<!-- Contact -->
<div id="contact" class="contact-section">
    <form method="POST" action="?action=contact">
        <div class="title">Contact me<img src="public/icons/contact.svg"></div>
        <div>
            <input type="text" name="name" placeholder="Your name">
        </div>
        <div>
            <input type="text" name="email" placeholder="Your email">
        </div>
        <div>
            <textarea name="message" placeholder="Message"></textarea>
        </div>
        <button class="btn btn-anim" type="submit"><span>Send</span><img src="public/icons/send.svg"></button>
    </form>
</div>
<!-- Footer -->
<?php require 'views/components/footer.php'; ?>