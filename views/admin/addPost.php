<div><strong>Add new post</strong></div>
<form method="POST" action="?controller=admin&action=addPost" enctype="multipart/form-data">
    <div>
        <input type="text" name="title" placeholder="Title"> 
    </div>
    <div>
        <textarea name="description" placeholder="Description"></textarea> 
    </div>
    <div>
        <input type="file" name="image">
    </div>
    <div>
        <input type="submit" value="Save"> 
    </div>
</form>