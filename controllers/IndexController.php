<?php

use core\Controller;
use services\validators\factory\ValidatorsFactory;

class IndexController extends Controller
{

    public function indexAction() 
    {    
        // Ajax loading posts
        if (!empty($_POST)) {
            $posts = $this->model->getCardPosts(PostsLimit, $_POST['loadFrom']);
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
        $posts = $this->model->getCardPosts($postsLimit, $page);
        $postsAmount = $this->model->getPostsAmount();
        $recomendedPosts = $this->model->getRecomendedPosts();
        
        // Transfering data
        $vars = [
            'adminData' => $adminData,
            'posts' => $posts,
            'postsAmount' => $postsAmount,
            'recomendedPosts' => $recomendedPosts
        ];
        
        $this->view->render($adminData['name'], $vars);
    }

    public function postAction()
    {
        $postId = isset($_GET['id']) ? intval($_GET['id']) : null;

        // Get request for loading comments
        if (isset($_GET['loadMoreComments'])) {
            $comments = $this->model->getPostComments($_GET['postId'], 5, $_GET['loadFrom']);
            echo json_encode($comments);
            exit();
        }

        // Add comment
        if (!empty($_POST)) {
            $form = ValidatorsFactory::create('comment');

            if ($form->checkError()) {
                $this->model->addComment($postId, $_POST);
                $this->view->reply('Comment added');
            } 
            $this->view->reply($form->getError(), 'error', false);
        }

        $post = $this->model->getPostById($postId);
        $comments = $this->model->getPostComments($postId, 5);
        $recomendedPosts = $this->model->getRecomendedPosts();
       
        if (!$post) $this->view->redirect();
    
        $vars = [
            'post' => $post,
            'comments' => $comments,
            'recomendedPosts' => $recomendedPosts
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
            exit();
        }
        $this->view->redirect();
    }

}