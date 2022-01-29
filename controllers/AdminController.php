<?php

use core\Controller;
use services\validators\factory\ValidatorsFactory;
use services\CodeGeneratorService;

class AdminController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->switchLayout($route['controller']);
    } 

    public function IndexAction()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $posts = $this->model->getCardPosts(PostsLimit, $page);
        $postsAmount = $this->model->getPostsAmount();
        
        // Pagination    
        $pagesAmount = empty($postsAmount) ? 1 : ceil($postsAmount / PostsLimit);
        if ($page > $pagesAmount || $page < 1) $this->view->redirect();
    
        // Transfering data
        $vars = [
            'posts' => $posts,
            'postsAmount' => $postsAmount,
            'pagesAmount' => $pagesAmount
        ];

        $this->view->render('Admin panel', $vars);
    }

    public function addPostAction()
    {
        if (!empty($_POST)) {
            $form = ValidatorsFactory::create('post', 'add');

            if ($form->checkError()) {
                $this->model->postAdd($_POST);
                $postId = $this->model->getLastPostId();
                $this->model->postUpdatePreview($postId);
                $this->model->postUploadImage($_FILES['image'], $postId);
                $this->view->reply('Post added', 'success', true, '?controller=admin');
            }

            $this->view->reply($form->getError(), 'error', false);
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
            
            $form = ValidatorsFactory::create('post', 'edit');
            if ($form->checkError()) {
                // Previous preview for replacing image
                $_POST['pre_preview'] = !empty($_FILES['image']['name']) ? $post['preview'] : null;
                $this->model->postUpdate($postId, $_POST);
                $this->model->postUploadImage($_FILES['image'], $postId);
                $this->view->reply('Post edited', 'success', true, '?controller=admin');
            }
            
            $this->view->reply($form->getError(), 'error', false);
        }

        // If post was not found -> redirect page
        if (!$post) $this->view->redirect('?controller=admin');

        $vars = [
            'post' => $post
        ];

        // Load page
        $this->view->render('Edit post', $vars);
    }

    public function deletePostAction()
    {
        if (!empty($_GET)) {
            $id = intval($_GET['id']);
            $this->model->deletePost($id);
            $this->model->removePostImage($id);
            $this->view->reply('Post deleted', 'success', true);
        }
    }

    public function profileAction()
    {
        $data = $this->model->getAdminData();

        if (!empty($_POST)) {
            $form = ValidatorsFactory::create('profile');

            if ($form->checkError()) {
                $_POST['pre_ava'] = $data['ava'];
                $_POST['pre_background'] = $data['background'];

                $this->model->saveData($_POST);
                $this->view->reply('Data changed', 'success', true, '?controller=admin&action=profile');
            }
            
            $this->view->reply($form->getError(), 'error', false);
        }
        
        $vars = [
            'data' => $data
        ];

        $this->view->render('Profile', $vars);
    }

    public function logsAction()
    {
        $logs = $this->model->getLogs();

        $vars = [
            'logs' => isset($logs) ? $logs : null
        ];

        $this->view->render('Logs story', $vars);
    }

    public function logoutAction()
    {
        // Remove session 
        if (isset($_SESSION['admin'])) unset($_SESSION['admin']);
        $this->view->redirect();
    }

    public function changePasswordAction()
    {
        if (!empty($_POST)) {
            $form = ValidatorsFactory::create('password');
            if ($form->checkError()) {
                unset($_SESSION['code']);
                $this->model->updatePassword($_POST['new_password']);
                $this->view->reply('Password changed', 'success', true, '?controller=admin&action=profile');
            }

            $this->view->reply($form->getError(), 'error', true, '?controller=admin&action=logout');
        }

        $email = $this->model->getAdminData()['email'];
        // Generating code
        $code = CodeGeneratorService::createCode();
        $_SESSION['code'] = md5($code);
        mail($email, 'Blog | ', 'Code: ' . $code);
    }
    
}