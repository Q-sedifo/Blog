<div class="preview" style="background-image: url(<?= $post['preview']; ?>);">
    <div class="post-title">
        <h2><?= $post['title']; ?></h2>
    </div>
</div>
<div class="page">
    <div class="top-tile"></div>
    <div class="container">
        <div class="post-description">
            <div class="post-info"><span class="post-id">#<?= $post['id']; ?></span><span><?= $post['datatime']; ?></span></div>
            <?= $post['descript']; ?>
        </div>
        <!-- Recomended posts -->
        <?php require_once 'views/components/recomendedPostsSection.php'; ?>
        <!-- Post comments -->
        <div class="comments-section">
            <div class="title">Comments <?= count($comments); ?><img src="public/icons/comments.svg"></div>
            <form method="POST" action="">
                <div>
                    <input type="text" name="name" placeholder="Name" value="Guest">
                </div>
                <div>
                    <textarea type="text" name="text" placeholder="Comment"></textarea>
                </div>
                <div>
                    <button class="btn btn-anim" type="submit"><span>Comment</span><img src="public/icons/send.svg"></button>
                </div>
            </form>
            <?php if ($comments): ?>
                <div class="comments-list">
                    <?php foreach ($comments as $comment): ?>
                        <div id="comment#<?= $comment['id']; ?>" class="comment">
                            <div class="comment-info">
                                <div><div class="comment-image"><img src="public/icons/user.svg"></div><?= $comment['name']; ?></div>
                                <?php if (isset($_SESSION['admin'])): ?>
                                    <button class="btn negative"><a href="?controller=admin&action=&commentId=<?= $comment['id']; ?>"></a>&times</button>
                                <?php endif; ?>
                            </div>
                            <div class="comment-text">
                                <?= $comment['text']; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="normal-message">No comments yet</div>
            <?php endif; ?>
            <?php if (count($comments) > 5): ?>
                <div class="center">
                    <div class="load-more-comments-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px"><path d="M24 24H0V0h24v24z" fill="none" opacity=".87"/><path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6-1.41-1.41z"/></svg>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Footer -->
<?php require 'views/components/footer.php'; ?>