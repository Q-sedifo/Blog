<div id="admin-profile-page" class="container">
    <form method="POST" action="?controller=admin&action=profile" enctype="multipart/form-data">
        <div class="title">Profile<img src="public/icons/account.svg"></div>
        <div class="wrapper-row">
            <div>
                <div class="label">Avatar:</div>
                <label class="ava preview" for="ava" style="background: linear-gradient(rgba(20, 20, 20, .5) 100%, rgba(0, 0, 0, .5) 100%), url(<?= $data['ava']; ?>);">
                    <img src="public/icons/addPhoto.svg">
                </label>
                <input id="ava" class="hide" type="file" name="ava">
            </div>
            <div>
                <div class="label">Background:</div>
                <label class="background preview" for="background" style="background: linear-gradient(rgba(20, 20, 20, .5) 100%, rgba(0, 0, 0, .5) 100%), url(<?= $data['background']; ?>);">
                        <img src="public/icons/addPhoto.svg">
                </label>
                <input id="background" class="hide" type="file" name="background">
            </div>
        </div>
        <div class="wrapper-row">
            <div>
                <label>Name:</label>
                <input type="text" name="name" placeholder="Name" value="<?= $data['name']; ?>">
            </div>
            <div>
                <label>Email:</label>
                <input type="text" name="email" placeholder="Email" value="<?= $data['email']; ?>">
            </div>
        </div>
        <div>
            <label>Bio:</label>
            <textarea name="bio" placeholder="Tell something about yourself"><?= $data['bio']; ?></textarea>
        </div>
        <div class="btns-section">
            <input class="btn positive" type="submit" value="Save">
            <button class="btn" type="button" onclick="sendCode()">Change password</button>
        </div>
    </form>
    <div id="changing-password-block" class="pop-up">
        <form method="POST" action="?controller=admin&action=changePassword" class="hide">
            <button class="close" type="button">&times;</button>
            <div class="title">Changing password<img src="public/icons/edit.svg"></div>
            <div class="small-message">A code was sned to your email</div>
            <div>
                <input type="text" name="code" placeholder="Code">
            </div>
            <div>
                <input type="text" name="new_password" placeholder="New password">
            </div>
            <div class="btns-section">
                <input class="btn" type="submit" value="Change">
            </div>
        </form>
    </div>
</div>
<!-- Footer -->
<?php require 'views/components/footer.php'; ?>
