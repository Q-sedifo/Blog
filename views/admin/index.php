<?php if (!isset($_GET['page'])) $_GET['page'] = 1; ?>
<!-- Posts list section -->
<div id="admin-posts-section" class="container">
    <div class="title"><div>Posts: <span id="postCount"><?= $postsAmount; ?></span></div><img src="public/icons/list.svg"></div>
    <div class="posts-list">
        <?php foreach ($posts as $post): ?>
            <div id="post<?= $post['id'] ?>" class="post-card">
                <div class="post-card-info">Id:<span class="post-id">#<?= $post['id']; ?></span></div>
                <div class="post-card-data">Date:<span><?= $post['datatime']; ?></span></div>
                <div class="post-card-title"><?= $post['title']; ?></div>
                <div class="post-card-preview" style="background: linear-gradient(rgba(20, 20, 20, .7) 0%, rgba(0, 0, 0, 0) 40%), url(<?= $post['mini_preview']; ?>);"></div>
                <div class="post-card-btns-block">
                    <button class="btn"><img src="public/icons/edit.svg"><a href="?controller=admin&action=editPost&id=<?= $post['id']; ?>"></a></button>
                    <button class="btn negative" onclick="deletePost(<?= $post['id']; ?>)"><img src="public/icons/cancel.svg"></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($posts): ?>
        <div class="pagination-line">
            <?php if ($_GET['page'] > 3): ?>
                <a href="?controller=admin&page=1">
                    <button>1</button>
                </a>
            <?php endif; ?>
            <?php if ($_GET['page'] > 4): ?>
                <div>...</div>
            <?php endif; ?>
            <?php for ($p = 1; $p <= $pagesAmount; $p++): ?>
                <?php if (isset($_GET['page']) && !($p > $_GET['page'] + 2) && !($p < $_GET['page'] - 2)): ?>
                    <a href="?controller=admin&page=<?= $p; ?>">
                        <button style="<?php if ($_GET['page'] == $p): ?>border: 1px solid #6478CE; color: #e6e6e6;<?php endif; ?>"><?= $p; ?></button>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($pagesAmount > 3 && $_GET['page'] < $pagesAmount - 2): ?>
                <div>...</div>
            <?php endif; ?>
            <?php if ($_GET['page'] < $pagesAmount - 2): ?>
                <a href="?controller=admin&page=<?= $pagesAmount; ?>">
                    <button style="<?php if ($_GET['page'] == $pagesAmount): ?>border: 1px solid #6478CE; color: #e6e6e6;<?php endif; ?>"><?= $pagesAmount; ?></button>
                </a>
            <?php endif; ?>
        <div>
    <?php else: ?>
        <a href="?controller=admin&action=addPost"><div class="box-icon" type="button"><img src="public/icons/add.svg"></div></a>
    <?php endif; ?>
</div>
<!-- Admin posts search -->
<div id="admin-posts-search-section" class="container">
    <div class="title">Posts search<img src="public/icons/search.svg"></div>
    <div class="search">
        <div>
            <span class="normal-message">Find by</span>
            <select>
                <option>Id</option>
                <option>Title</option>
            </select>
        </div>
        <div>
            <input id="postSearcher" type="text" placeholder="Post id or title">
            <button class="btn" onclick="findPostByType()"><img src="public/icons/search.svg"></button>
        </div>
    </div>
    <div id="foundPosts" class="posts-list">
        <div class="normal-message">...</div>
    </div>
</div>