<?php

namespace services\validators;

use core\FormHelper;
use core\AdminManager;

class LoginValidator extends FormHelper
{

    private $fields = ['login', 'password'];
    private $password;
    
    public function __construct($post)
    {
        parent::__construct($this->fields, $post);
        $this->password = AdminManager::getPassword();
        $this->checkFields();
    }

    private function checkFields()
    {
        $this->checkLogin();
        $this->checkPassword();
    }

    private function checkLogin()
    {
        $login = $this->post['login'];

        if (empty($login)) {
            $this->addError('Fill login');
        }
        else if ($login !== 'admin') {
            $this->addError('Incorrect login or password');
        }
    }

    private function checkPassword()
    {
        $password = $this->post['password'];

        if (empty($password)) {
            $this->addError('Fill password');
        }
        else if (!password_verify($password, $this->password)) {
            $this->addError('Incorrect login or password');
        }
    }

}