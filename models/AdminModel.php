<?php

use core\Model;

class AdminModel extends model
{

    public function getLogs()
    {
        $file = PathLogs;
        if (file_exists($file)) {
            return $logs = array_reverse(explode('|', file_get_contents($file)));
        }
    }

    public function getAllPosts()
    {
        return $this->query->row('SELECT * from posts ORDER BY datatime DESC');
    }

    public function getPostsAmount()
    {
        return $this->query->column('SELECT COUNT(id) as amount FROM posts');
    }

    public function getPostById($post_id)
    {
        $result = $this->query->row("SELECT * FROM posts WHERE id = $post_id");
        foreach ($result[0] as $key => $value) $post[$key] = $value; 
        return $post;
    }

    public function getPostId()
    {
        return $this->query->column("SELECT MAX(id) FROM posts");
    }

    public function updatePostPreview($id)
    {
        $preview = PostImgPath . $id . '.jpg';
        return $this->query->row("UPDATE posts SET preview = '$preview' WHERE id = $id");
    }

    public function postValidate($post, $type)
    {  
        $title = iconv_strlen(trim($post['title']));
        $description = iconv_strlen(trim($post['description']));

        if ($title == 0 || $description == 0) {
            $this->error = 'Fill all fields';
        }

        else if ($title < 5 || $title > 62) {
            $this->error = 'Title must contain from 5 to 62 letters';
        }

        else if ($description < 20 || $description > 1000) {
            $this->error = 'Description must contain from 20 to 1000 letters';
        }

        else if ($type == 'add' && empty($_FILES['image']['tmp_name'])) {
            $this->error = 'Insert image';
        }

        if ($this->error) return false;
        else return true;
    }

    public function adminDataValidate($post)
    {
        $name = iconv_strlen(trim($post['name']));
        $email = trim($post['email']);
        $bio = iconv_strlen(trim($post['bio']));

        if ($name <= 0 || $name > 32) {
            $this->error = 'Incorrect name';
        }

        else if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Incorrect email';
        }

        else if ($bio <= 10 || $bio > 1000) {
            $this->error = 'Bio must contain from 10 to 1000 letters';
        }

        if ($this->error) return false;
        else return true;
    }

    public function postEdit($post_id, $post)
    {
        $title = htmlentities(trim($post['title']));
        $desc = htmlentities(trim($post['description']));
        $preview = htmlentities(trim($post['preview']));
        
        $this->query->row("UPDATE posts SET title = '$title', descript = '$desc', preview = '$preview' WHERE id = $post_id");
        return true;
    }   

    public function addPost($post)
    {
        $title = htmlentities(trim($post['title']));
        $desc = htmlentities(trim($post['description']));
        $preview = htmlentities(trim($post['preview']));
        
        $this->query->row("INSERT INTO posts (title, descript, preview) VALUES('$title', '$desc', '$preview')");
        return true;
    }

    public function saveData($post)
    {   
        $post['ava'] = AvatarImgPath . 'jpg';
        $post['background'] = BackgroundImgPath . 'jpg';
        if (!empty($_FILES['ava']['tmp_name'])) {
            move_uploaded_file($_FILES['ava']['tmp_name'], $post['ava']);
        }
        else if (!empty($_FILES['background']['tmp_name'])) {
            move_uploaded_file($_FILES['background']['tmp_name'], $post['background']);
        }

        $file = file_get_contents('config/adminData.json');
        $data = json_decode($file, true);

        foreach ($post as $key => $value) {
            $data[$key] = trim($value);
        }

        file_put_contents('config/adminData.json', json_encode($data));
        return true;
    }

    public function uploadFile($path, $file) 
    {
        move_uploaded_file($path, PostImgPath . $file . '.jpg');
    }

}