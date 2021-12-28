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

}