<?php

namespace services\validators;

use core\FormHelper;

class ContactValidator extends FormHelper
{

    private $fields = ['name', 'email', 'message'];

    public function __construct($post)
    {
        parent::__construct($this->fields, $post);
        $this->checkFields();
    }

    private function checkFields()
    {
        $this->checkName();
        $this->checkEmail();
        $this->checkMessage();
    }

    private function checkName()
    {
        $name = $this->post['name'];

        if (iconv_strlen($name) < 2) {
            $this->addError('Too short name');
        }
        else if (iconv_strlen($name) > 20) {
            $this->addError('Too long name');
        }
    }

    private function checkEmail()
    {
        $email = $this->post['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('Incorrect email');
        }
    }

    private function checkMessage()
    {
        $message = $this->post['message'];

        if (iconv_strlen($message) < 5 || iconv_strlen($message) > 400) {
            $this->addError('Message must contain more than 5 and less than 400 letters');
        }
    }

}