<?php

// Show all errors
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Start session
session_start();

// Including config file
require_once 'config/config.php';

// Namespace
use core\Router;

// Autoloading classes
spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class . '.php');

    if (file_exists($path)) {
        require_once $path;
    }
});

// Starting router
$router = Router::getInstance();
$router->run();