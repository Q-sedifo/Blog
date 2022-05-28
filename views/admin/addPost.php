<div id="add-post-page" class="container">
    <form method="POST" action="?controller=admin&action=addPost" enctype="multipart/form-data">
        <div class="title">Add new post<img src="public/icons/addPost.svg"></div>
        <div class="center">
            <label class="post-preview" for="image" style="background-image: url(<?= $post['mini_preview']; ?>);">
                <div>
                    <img src="public/icons/addPhoto.svg">
                </div>
            </label>
            <input id="image" class="hide" type="file" name="image">
        </div>
        <div>
            <label>Title:</label>
            <input type="text" name="title" placeholder="Title"> 
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description" placeholder="Description"></textarea> 
        </div>
        <div class="btns-section">
            <input class="btn" type="submit" value="Publish"> 
        </div>
    </form>
</div>