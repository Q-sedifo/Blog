<div class="preview" style="background-image: url(<?= $post['preview']; ?>);">
    <div class="post-title">
        <h2><?= $post['title']; ?></h2>
    </div>
</div>
<div class="page">
    <div class="top-tile"></div>
    <div class="container">
        <div class="post-description">
            <div class="post-info"><span class="post-id">#<span id="postId"><?= $post['id']; ?></span></span><span><?= $post['datatime']; ?></span></div>
            <?= $post['descript']; ?>
        </div>
        <!-- Recomended posts -->
        <?php require_once 'views/components/recomendedPostsSection.php'; ?>
        <!-- Post comments -->
        <div class="comments-section">
            <div class="title">Comments <?= $commentsAmount; ?><img src="public/icons/comments.svg"></div>
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
                                    <button class="btn negative" onclick="deleteComment(<?= $comment['id']; ?>)">&times</button>
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
        </div>
    </div>
</div>
<!-- Footer -->
<?php require 'views/components/footer.php'; ?>