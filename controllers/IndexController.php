<?php

use core\Controller;

class IndexController extends Controller
{

    public function indexAction() 
    {    
        // Page control
        $page_params = [
            'page' => isset($_GET['page']) ? intval($_GET['page']) : 1,
            'postsLimit' => 3
        ];
        extract($page_params);
        
        // Getting data from db
        $adminData = $this->model->getAdminData();
        $posts = $this->model->getPosts($postsLimit, $page);
        $postsAmount = $this->model->getPostsAmount();
        
        // Pagination
        $pagesAmount = ceil($postsAmount / $postsLimit);

        if ($page > $pagesAmount || $page <= 0) $this->view->redirect();

        // Transfering data
        $vars = [
            'adminData' => $adminData,
            'posts' => $posts,
            'postsAmount' => $postsAmount,
            'pagesAmount' => $pagesAmount
        ];
        
        $this->view->render($adminData['name'], $vars);
    }

    public function contactAction()
    {
        if (!empty($_POST)) {
            if ($this->model->contactValidate($_POST)) {
                $adminEmail = $this->model->getAdminEmail();

                // Send message on email
                mail($adminEmail, 'Blog', $_POST['name'] . '|' . $_POST['email'] . '|' . $_POST['message']);

                // Show message
                $this->view->message('Message sent successfully');
            }
            else {
                $this->view->message($this->model->error, 'error', false);
            }
            exit();
        }

        $this->view->render('Contact');
    }

    public function loginAction()
    {
        // Access control
        if (isset($_SESSION['admin'])) {
            $this->view->redirect();
        }

        // Login function
        if (!empty($_POST)) {
            if ($this->model->loginValidate($_POST)) {
                $adminData = $this->model->getAdminData(true);

                // Fix logs with ip and date
                $ip = $_SERVER['REMOTE_ADDR'];
                date_default_timezone_set('Europe/Kiev');

                $logs = fopen('logs.txt', 'a');
                fwrite($logs, $ip . '[' . date('Y-m-d, H:i') . ']' . '|');
                fclose($logs);

                // Login, create session and inform
                $_SESSION['admin'] = $adminData;
                $this->view->message('You logged in');
            }
            else {
                $this->view->message($this->model->error, 'error', false);
            }
            exit();
        }

        $this->view->render('Login');
    }

}