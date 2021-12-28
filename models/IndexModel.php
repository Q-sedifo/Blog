<?php

use core\Model;

class IndexModel extends Model
{

    public function getPosts($limit = 0, $page = 1)
    {
        $range = $limit * ($page - 1);
        return $this->query->row("SELECT * FROM posts ORDER BY id DESC LIMIT $range, $limit");
    }

    public function getPostsAmount()
    {
        $result = $this->query->row('SELECT COUNT(id) as amount FROM posts');
        return $result[0]['amount'];
    }

    public function getAdminData($password = false)
    {
        $data = require 'config/data.php';

        // Ckeck premission for getting admin password
        if ($password) return $data;
        else {
            foreach ($data as $key => $value) {
                if ($key != 'password') $admin[$key] = $value; 
            }
            return $admin;
        }
    }

    public function getAdminEmail()
    {
        $data = $this->getAdminData();
        return $data['email'];
    }

    public function contactValidate($post)
    {
        $name = iconv_strlen($post['name']);
        $message = iconv_strlen($post['message']);
        $email = $post['email'];
        
        if ($name < 2 || $name > 32) {
            $this->error = 'Input correct name';
        }

        else if ($message < 5 || $message > 400) {
            $this->error = 'Message must contain more than 5 and less than 400 letters';
        }
        
        else if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Incorrect email, try again';
        }
       
        // Errors checking
        if ($this->error) return false;
        else return true;
    }

}