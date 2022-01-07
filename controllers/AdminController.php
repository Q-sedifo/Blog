<?php

use core\Controller;

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
        $postsAmount = $this->model->getPostsAmount();

        // Transfering data
        $vars = [
            'posts' => $posts,
            'postsAmount' => $postsAmount
        ];

        $this->view->render('Admin panel', $vars);
    }

    public function addPostAction()
    {
        if (!empty($_POST)) {
            if ($this->model->postValidate($_POST, 'add')) {
                $_POST['preview'] = '...';
                $this->model->addPost($_POST);
                $postId = $this->model->getPostId();
                $this->model->updatePostPreview($postId);
                $this->model->uploadFile($_FILES['image']['tmp_name'], $postId);
                $this->view->reply('The post was added successfully', 'success', true, '?controller=admin');
            } 
            $this->view->reply($this->model->error, 'error', false);
        }

        $this->view->render('Add post');
    }
    
    public function editPostAction()
    {
        // Getting post id from Get
        $postId = isset($_GET['id']) ? intval($_GET['id']) : null;
        $post = $this->model->getPostById($postId);

        // Verifying POST for getting data
        if (!empty($_POST)) {
            // Default value of post preview
            $_POST['preview'] = empty($_FILES['image']['name']) ? $post['preview'] : trim($_FILES['image']['name']);

            if ($this->model->postValidate($_POST, 'edit')) {
                // Checking for new image
                if (!empty($_FILES['image']['tmp_name'])) {
                    // Replace image
                    if (file_exists($post['preview'])) unlink($post['preview']);
                    $this->model->uploadFile($_FILES['image']['tmp_name'], $postId);
                    $_POST['preview'] = PostImgPath . $postId . '.jpg';
                }
                
                // Save changes in db
                $this->model->postEdit($postId, $_POST);
                $this->view->reply('Post was edited successfully', 'success', true, '?controller=admin');
            }
            
            $this->view->reply($this->model->error, 'warning', false);
        }

        // If post was not found -> redirect page
        if (!$post) $this->view->redirect('?controller=admin');

        $vars = [
            'post' => $post
        ];

        // Load page
        $this->view->render('Edit post', $vars);
    }

    public function profileAction()
    {
        if (!empty($_POST)) {
            if ($this->model->adminDataValidate($_POST)) {
                $this->model->saveData($_POST);
                $this->view->reply('Data changed successfully', 'success', true, '?controller=admin&action=profile');
            }
            $this->view->reply($this->model->error, 'error', false);
        }

        $data = $this->model->getAdminData();
        
        $vars = [
            'data' => $data
        ];

        $this->view->render('Profile', $vars);
    }

    public function logsAction()
    {
        // Getting logs list
        $logs = $this->model->getLogs();
        $logsSize = file_exists(PathLogs) ? filesize(PathLogs) : 0;

        // Transfer data
        $vars = [
            'logs' => isset($logs) ? $logs : null,
            'fileSize' => $logsSize
        ];

        $this->view->render('Logs story', $vars);
    }

    public function cleanLogsAction()
    {
        if (file_exists(PathLogs)) unlink(PathLogs);
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