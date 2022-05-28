<div id="edit-post-page" class="container">
    <form method="POST" action="?controller=admin&action=editPost&id=<?= $post['id']; ?>" enctype="multipart/form-data">
        <div class="title">Edit post<img src="public/icons/edit.svg"></div>
        <div class="center">
            <label class="post-preview" for="image" style="background-image: url(<?= $post['mini_preview']; ?>);">
                <div>
                    <img src="public/icons/addPhoto.svg">
                </div>
            </label>
            <input id="image" class="hide" type="file" name="image">
        </div>
        <div class="info">id: <div>#<?= $post['id']; ?></div></div>
        <div class="info">date: <div><?= $post['datatime']; ?></div></div>
        <div>
            <label>Title:</label>
            <input type="text" name="title" placeholder="Title" value="<?= $post['title']; ?>"> 
        </div>
        <div>
            <label>Descripion:</label>
            <textarea name="description" placeholder="Description"><?= $post['descript']; ?></textarea> 
        </div>
        <div class="btns-section">
            <input class="btn positive" type="submit" value="Save"> 
        </div>
    </form>
</div>
