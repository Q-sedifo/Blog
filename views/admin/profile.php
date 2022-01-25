<div><strong>Profile</strong></div>
<?php print_r($data); ?>
<form method="POST" action="?controller=admin&action=profile" enctype="multipart/form-data">
    <div>
        <input type="file" name="ava">
    </div>
    <div>
        <input type="text" name="name" placeholder="Name" value="<?= $data['name']; ?>">
    </div>
    <div>
        <input type="text" name="email" placeholder="Email" value="<?= $data['email']; ?>">
    </div>
    <div>
        <textarea name="bio" placeholder="Bio"><?= $data['bio']; ?></textarea>
    </div>
    <div>
        <input type="file" name="background">
    </div>
    <div>
        <input type="submit" value="Save">
    </div>
</form>
<button type="button" onclick="sendCode()">Change password</button>
<div>Change password</div>
<form method="POST" action="?controller=admin&action=changePassword">
    <div>
        <input type="text" name="code">
    </div>
    <div>
        <input type="password" name="new_password">
    </div>
    <div>
        <input type="submit" value="Change">
    </div>
</form>