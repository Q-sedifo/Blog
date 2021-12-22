<?php

namespace core;

use core\View; 

class Router 
{
    public $route;

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