<?php

use core\Controller;
use services\validators\factory\ValidatorsFactory;

class IndexController extends Controller
{

    public function indexAction() 
    {    
        // Ajax loading posts
        if (!empty($_POST)) {
            $posts = $this->model->getPosts(PostsLimit, $_POST['loadFrom']);
            echo json_encode($posts);
            exit();
        }

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
        $pagesAmount = empty($postsAmount) ? 1 : ceil($postsAmount / $postsLimit);
        
        if ($page > $pagesAmount || $page < 0) $this->view->redirect();
    
        // Transfering data
        $vars = [
            'adminData' => $adminData,
            'posts' => $posts,
            'postsAmount' => $postsAmount,
            'pagesAmount' => $pagesAmount
        ];
        
        $this->view->render($adminData['name'], $vars);
    }

    public function postAction()
    {
        $postId = isset($_GET['id']) ? intval($_GET['id']) : null;
        $post = $this->model->getPostById($postId);

        if (!$post) $this->view->redirect();

        $vars = [
            'post' => $post
        ];
        
        $this->view->render($post['title'], $vars);
    }

    public function contactAction()
    {
        if (!empty($_POST)) {
            $form = ValidatorsFactory::create('contact');

            if ($form->checkError()) {
                $adminData = $this->model->getAdminData();
                // Send message on email
                mail($adminData['email'], 'Blog', $_POST['name'] . '|' . $_POST['email'] . '|' . $_POST['message']);

                $this->view->reply('Message sent', 'success', true);
            }
            
            $this->view->reply($form->getError(), 'error', false);
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
            $form = ValidatorsFactory::create('login');

            if ($form->checkError()) {
                $admin = $this->model->getAdminData();
                // Fix logs with ip and date
                $this->model->saveLog();
                // Login, create session and inform
                $_SESSION['admin'] = $admin;

                $this->view->reply('You logged in', 'success', true, '?controller=admin');
            } 
            
            $this->view->reply($form->getError(), 'error', false);
        }

        $this->view->render('Login');
    }

    public function postSearchAction()
    {
        if (!empty($_POST)) {
            $posts = $this->model->searchPosts($_POST['title']);
            echo json_encode($posts);
        }
    }

}