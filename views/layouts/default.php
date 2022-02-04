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
        <!-- Link styles -->
        <link href="public/css/styles.css" rel="stylesheet">
        <title>Blog | <?= $title; ?></title>
    </head>
    <body>
        <main>
            <!-- Header -->
            <header>
                <div class="container">
                    <div class="acc">
                        <img src="<?php if (isset($_SESSION['admin'])): ?><?= $_SESSION['admin']['ava'] ?><?php else: ?>public/icons/user.svg<?php endif; ?>">
                        <!-- Preloader -->
                        <div id="preloader"></div>
                    </div>
                    <!-- Logo -->
                    <div id="logo"><img src="public/icons/logo.svg"></div>
                    <!-- Menu-btn -->
                    <div id="menu-btn"><img src="public/icons/menu.svg"></div>
                </div>
            </header>
            <!-- Content -->
            <?= $content; ?>
        </main>
    </body>
</html>