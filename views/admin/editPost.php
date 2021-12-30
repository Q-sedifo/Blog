<div>Edit post</div>
<div>id: <?= $post['id']; ?></div>
<div>date: <?= $post['datatime']; ?></div>
<form method="POST" action="?controller=admin&action=editPost&id=<?= $post['id']; ?>">
    <div>
        <input type="text" name="title" placeholder="Title" value="<?= $post['title']; ?>"> 
    </div>
    <div>
        <textarea name="description" placeholder="Description"><?= $post['descript']; ?></textarea> 
    </div>
    <div>
        <input type="button" value="Save"> 
    </div>
</form>