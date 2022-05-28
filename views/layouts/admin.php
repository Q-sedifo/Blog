<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Link the shortcut icon -->
        <link rel="shortcut icon" href="public/icons/logo.svg">
        <!-- Link Jquery -->
        <script src="library/js/jquery.js"></script>
        <!-- Link Notification script -->
        <script src="library/notification/script.js"></script>
        <link rel="stylesheet" href="library/notification/message.css">
        <!-- Link main js script -->
        <script src="public/js/script.js"></script>
        <!-- Admin functions -->
        <script src="public/js/adminFunctions.js"></script>
        <!-- Link fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <!-- Link styles -->
        <link href="public/css/styles.css" rel="stylesheet">
        <title>Blog | <?= $title; ?></title>
    </head>
    <body>
        <main>
            <!-- Admin menu -->
            <?php require_once 'views/components/adminMenu.php'; ?>
            <!-- Header -->
            <?php require_once 'views/components/header.php'; ?>
            <!-- Logs -->
            <?php require_once 'views/components/logs.php'; ?>
            <!-- Content -->
            <?= $content; ?>
        </main>
    </body>
</html>