<?php

namespace core;

class View 
{
    public $path;
    public $layout = 'default';

    public function __construct($route)
    {
        // Receiving route
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = [])
    {
        $path = 'views/' . $this->path . PathPostfix;
        
        // Extracting variables from array
        extract($vars);

        if (file_exists($path)) {
            ob_start();
            require_once $path;
            $content = ob_get_clean();
            require_once 'views/layouts/' . $this->layout . PathPostfix;

        } else {
            echo 'View is not detected: ' . $path;
        }
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        require_once 'views/errors/' . $code . PathPostfix;
        exit();
    }

    public function reply($message, $type = 'success', $success = true, $href = false)
    {
        $data['success'] = $success;
        $data['type'] = $type;
        $data['message'] = $message;
        $data['href'] = $href;

        echo json_encode($data);
    }

    public function redirect($url = '/Blog')
    {
        header('Location: ' . $url); 
    }

}