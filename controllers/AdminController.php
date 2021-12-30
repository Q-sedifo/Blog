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


    public function logoutAction()
    {
        // Remove session 
        if (isset($_SESSION['admin'])) unset($_SESSION['admin']);

        // Redirect page
        $this->view->redirect();
    }

}