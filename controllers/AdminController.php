<?php

use core\controller;

class AdminController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->switchLayout($route['controller']);
    }

    public function IndexAction()
    {
        

        $this->view->render('Admin panel');
    }

    public function logsAction()
    {
        // Getting logs list
        $file = 'logs.txt';
        if (file_exists($file)) {
            $logs = explode('|', file_get_contents($file));
            $fileSize = filesize($file);
        }

        // Transfer data
        $vars = [
            'logs' => isset($logs) ? $logs : null,
            'fileSize' => isset($fileSize) ? $fileSize : 0
        ];

        $this->view->render('Logs story', $vars);
    }

    public function clearLogsAction()
    {
        $file = 'logs.txt';
        if (file_exists($file)) unlink($file);

        $this->view->redirect('?controller=admin&action=logs');
    }

    public function logoutAction()
    {
        // Remove session 
        if (isset($_SESSION['admin'])) unset($_SESSION['admin']);

        // Redirect page
        $this->view->redirect();
    }

}