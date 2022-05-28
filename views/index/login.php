<div id="login-page">
    <div class="form-wrapper container">
        <form method="POST" action="?action=login">
            <div class="title">Account<img src="public/icons/admin.svg"></div>
            <div>
                <input type="text" name="login" placeholder="Login">
            </div>
            <div>
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="btns-section">
                <input class="btn positive" type="submit" value="Login">
            </div>
        </form>
    </div>
    <!-- Footer -->
    <?php require 'views/components/footer.php'; ?>
</div>