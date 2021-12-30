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
        $posts = $this->model->getAllPosts();

        // Transfering data
        $vars = [
            'posts' => $posts
        ];

        $this->view->render('Admin panel', $vars);
    }

    public function editPostAction()
    {
        // Getting post id from Get
        $postId = isset($_GET['id']) ? intval($_GET['id']) : null;
    
        $post = $this->model->getPostById($postId);
        
        if (!$post) $this->view->redirect('?controller=admin');

        // Transfering data
        $vars = [
            'post' => $post
        ];

        $this->view->render('Edit post', $vars);
    }

    public function logsAction()
    {
        // Getting logs list
        $logs = $this->model->getLogs();
        $logsSize = $this->model->getLogsSize();

        // Transfer data
        $vars = [
            'logs' => isset($logs) ? $logs : null,
            'fileSize' => $logsSize ? $logsSize : 0
        ];

        $this->view->render('Logs story', $vars);
    }

    public function cleanLogsAction()
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