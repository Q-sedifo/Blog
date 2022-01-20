<?php

namespace core;

use core\View; 

class Router 
{
    public $route;
    static private $_instance;

    private function __construct() {}
    private function __clone() {}

    // Singleton pattern
    static public function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }

        return self::$_instance = new self;
    }

    public function run() 
    {
        $this->getUrl();

        $controllerName = ucfirst($this->route['controller']) . 'Controller';
        $actionName = $this->route['action'] . 'Action';

        $path = PathPrefix . $controllerName . PathPostfix;

        // Checking for controller existence
        if (file_exists($path)) {
            require_once $path;
            $controller = new $controllerName($this->route);

            if (method_exists($controllerName, $actionName)) {
                $controller->$actionName();
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

    public function getUrl() 
    {
        $this->route['controller'] = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        $this->route['action'] = isset($_GET['action']) ? $_GET['action'] : 'index';
    }

}