<strong>Login</strong>
<form method="POST" action="?action=login" reload="true">
    <div>
        <input type="text" name="login" placeholder="Login">
    </div>
    <div>
        <input type="password" name="password" placeholder="Password">
    </div>
    <div>
        <input type="button" onclick="request(this.form)" value="Login">
    </div>
</form>