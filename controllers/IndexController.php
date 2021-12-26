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

        if ($page > $pagesAmount) $this->view->redirect();

        // Transfering data
        $vars = [
            'adminData' => $adminData,
            'posts' => $posts,
            'postsAmount' => $postsAmount,
            'pagesAmount' => $pagesAmount
        ];
        
        $this->view->render($adminData['name'], $vars);
    }

}