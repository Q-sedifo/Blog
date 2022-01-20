<?php

// Define controllers constants
define('PathPrefix', 'controllers/');
define('PathPostfix', '.php');

// Define data path constants
define('PathLogs', 'logs.txt');

// Page settings
define('PostsLimit', 3);

// Define constants for image path
define('ImgPath', 'public/images/');
define('PostImgPath', ImgPath . 'posts/');
define('DataImgPath', ImgPath . 'data/');

define('AvatarImgPath', DataImgPath . 'ava.');
define('BackgroundImgPath', DataImgPath . 'background.');

// Timezone
date_default_timezone_set('Europe/Kiev');

// Acceptable types of file
$imgTypes = [
    'jpeg', 'jpg', 'png', 'gif' 
];
