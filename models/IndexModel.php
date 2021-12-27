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

    public function getAdminData()
    {
        $data = $this->query->row('SELECT `name`, `bio`, `img`, `background` FROM `admin`');
        foreach ($data[0] as $name => $value) $result[$name] = $value;
        return $result;
    }

    public function getAdminEmail()
    {
        return $this->query->column('SELECT email FROM `admin`');
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