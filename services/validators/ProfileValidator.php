<?php

namespace services\validators;

use core\FormHelper;
use services\ImageService;

class ProfileValidator extends FormHelper
{

    private $fields = ['name', 'email', 'bio'];

    public function __construct($post)
    {
        parent::__construct($this->fields, $post);
        $this->checkFields();
    }

    private function checkFields()
    {
        $this->checkName();
        $this->checkEmail();
        $this->checkBio();
        $this->checkImages();
    }

    private function checkName()
    {
        $name = $this->post['name'];

        if (empty($name)) {
            $this->addError('Fill name');
        }
        else if (iconv_strlen($name) > 20) {
            $this->addError('Too long name');
        }
    }

    private function checkEmail()
    {
        $email = $this->post['email'];

        if (empty($email)) {
            $this->addError('Fill email');
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('Incorrect email');
        }
    }

    private function checkBio() 
    {
        $bio = $this->post['bio'];

        if (empty($bio)) {
            $this->addError('Fill bio');
        }
        else if (iconv_strlen($bio) > 500) {
            $this->addError('Too long bio');
        }
    }

    private function checkImages()
    {
        $avatar = $_FILES['ava'];
        $background = $_FILES['background'];

        if (!empty($avatar['tmp_name']) && !ImageService::imgTypeValidate($avatar['name'])) {
            $this->addError('Incorrect avatar type');
        }
        if (!empty($background['tmp_name']) && !ImageService::imgTypeValidate($background['name'])) {
            $this->addError('Incorrect background type');
        }
    }

}