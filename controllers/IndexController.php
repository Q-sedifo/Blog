<?php

use core\Controller;

class IndexController extends Controller
{

    public function indexAction() 
    {    
        // Page control
        $page_params = [
            'page' => isset($_GET['page']) ? intval($_GET['page']) : 1,
            'postsLimit' => PostsLimit
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
                $email = $this->model->getAdminEmail();
               
                // Send message on email
                mail($email, 'Blog', $_POST['name'] . '|' . $_POST['email'] . '|' . $_POST['message']);

                // Inform user for successfully sending
                $this->view->reply('Message sent successfully', 'success', true, '?controller=index');
            }
            
            $this->view->reply($this->model->error, 'error', false);
        }

        // Render contact page
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

                $logs = fopen(PathLogs, 'a');
                fwrite($logs, $ip . '[' . date('Y-m-d, H:i') . ']' . '|');
                fclose($logs);

                // Login, create session and inform
                $_SESSION['admin'] = $adminData;
                $this->view->reply('You logged in', 'success', true, '?controller=admin');
            }
            
            $this->view->reply($this->model->error, 'error', false);
        }

        $this->view->render('Login');
    }

}