<?php

namespace core;

use core\View;

abstract class Controller
{
    public $route;
    public $view;
    public $model;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->checkAccess();
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $modelName = ucfirst($name) . 'Model';
        $path = 'models/' . $modelName . PathPostfix;
    
        if (file_exists($path)) {
            require $path;
            if (class_exists($modelName)) {
                return new $modelName();
            }
            else {
                echo 'Model class is not fount: ' . $modelName;
            }
        }
        else {
            echo 'Model file is not found: ' . $path;
        }
    }

    public function switchLayout($layout)
    {
        $this->view->layout = $layout;
    }

    private function checkAccess() 
    {
        $controller = $this->route['controller'];
        $action = $this->route['action'];

        if ($controller == 'admin' && !isset($_SESSION['admin'])) {
            $this->view->redirect();
        }
    }

}