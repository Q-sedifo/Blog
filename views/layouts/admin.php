<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link Jquery -->
    <script src="library/js/jquery.js"></script>
    <!-- Link Notification script -->
    <script src="library/notification/script.js"></script>
    <link rel="stylesheet" href="library/notification/message.css">
    <!-- Link main js script -->
    <script src="public/js/script.js"></script>
    <title>Blog | <?= $title; ?></title>
</head>
<body>
    <strong>Admin panel</strong>
    <div><a href="/Blog">Home</a></div>
    <div><a href="?controller=admin&action=logout">Logout</a></div>
    <div><a href="?controller=admin&action=logs">Logs</a></div>
    <?= $content; ?>
</body>
</html>