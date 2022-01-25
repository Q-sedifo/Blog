<?php

namespace services\validators;

use core\FormHelper;

class PasswordValidator extends FormHelper
{

    private $fields = ['code', 'new_password'];

    public function __construct($post)
    {
        parent::__construct($this->fields, $post);
        $this->checkFields();
    }

    private function checkFields()
    {
        $this->checkCode();
        $this->ckeckPassword();
    }

    private function checkCode()
    {   
        $code = $this->post['code'];
        if (md5($code) !== $_SESSION['code']) {
            $this->addError('Incorrect code');
        }
    }

    private function ckeckPassword()
    {
        $password = $this->post['new_password'];
        if (empty($password)) {
            $this->addError('Input password');
        }
        else if (iconv_strlen($password) < 3) {
            $this->addError('Too short password');
        }
        else if (iconv_strlen($password) > 12) {
            $this->addError('Too long password');
        }
    }

}