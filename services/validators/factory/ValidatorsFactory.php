<?php

namespace services\validators\factory;

use services\validators\LoginValidator;
use services\validators\ContactValidator;
use services\validators\PostValidator;
use services\validators\ProfileValidator;
use services\validators\PasswordValidator;

class ValidatorsFactory 
{
    static public function create($obj, $type = null)
    {
        switch($obj) {
            case 'login':
                return new LoginValidator($_POST);
                break;
            case 'contact':
                return new ContactValidator($_POST);
                break;
            case 'post':
                return new PostValidator($_POST, $type);
                break;
            case 'profile':
                return new ProfileValidator($_POST);
                break;
            case 'password': 
                return new PasswordValidator($_POST);
                break;
        }
    }
}