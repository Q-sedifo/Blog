<?php

use core\Model;

class AdminModel extends model
{

    public function loginValidate($post)
    {
        // Getting admin data for verifying 
        $adminData = $this->getAdminData(true);

        $login = $post['login'];
        $password = $post['password'];

        if (iconv_strlen($login) <= 0 || iconv_strlen($password) <= 0) {
            $this->error = 'Fill all fields';
        }

        else if ($login != 'admin' || !password_verify($password, $adminData['password'])) {
            $this->error = 'Incorrect login or password';
        }

        if ($this->error) return false;
        else return true;
    }

}