<div><strong>Edit post</strong></div>
<div>id: <?= $post['id']; ?></div>
<div>date: <?= $post['datatime']; ?></div>
<form method="POST" action="?controller=admin&action=editPost&id=<?= $post['id']; ?>" enctype="multipart/form-data">
    <div>
        <input type="text" name="title" placeholder="Title" value="<?= $post['title']; ?>"> 
    </div>
    <div>
        <textarea name="description" placeholder="Description"><?= $post['descript']; ?></textarea> 
    </div>
    <div>
        <input type="file" name="image">
    </div>
    <div>
        <input type="submit" value="Save"> 
    </div>
</form>
<div><?= $post['preview']; ?></div>
