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

    public function getLogsSize()
    {
        if (file_exists(PathLogs)) return filesize(PathLogs);
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

    public function postValidate($post)
    {
        global $imgTypes; // Permissible types of image
       
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

        if (empty($post['preview'])) {
            $this->error = 'Insert image';
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

    public function uploadFile($path, $file) 
    {
        move_uploaded_file($path, PostImgPath . $file . '.jpg');
    }

}