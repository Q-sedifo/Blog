<?php

use core\controller;

class AdminController extends Controller
{

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

    public function logoutAction()
    {
        // Remove session 
        if (isset($_SESSION['admin'])) unset($_SESSION['admin']);

        // Redirect page
        $this->view->redirect();
    }

}