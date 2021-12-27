<strong>Call back</strong>
<form method="POST" action="?action=contact">
    <div>
        <input type="text" name="name" placeholder="Your name">
    </div>
    <div>
        <input type="text" name="email" placeholder="Your email">
    </div>
    <div>
        <textarea name="message" placeholder="Message"></textarea>
    </div>
    <input type="button" onclick="request(this.form)" value="Send">
</form>