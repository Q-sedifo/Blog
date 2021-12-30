<?php

use core\Model;

class AdminModel extends model
{

    public function getLogs()
    {
        $file = 'logs.txt';
        if (file_exists($file)) {
            return $logs = array_reverse(explode('|', file_get_contents($file)));
        }
    }

    public function getLogsSize()
    {
        if (file_exists('logs.txt')) return filesize('logs.txt');
    }

    public function getAllPosts()
    {
        return $this->query->row('SELECT * from posts ORDER BY datatime DESC');
    }

    public function getPostById($post_id)
    {
        $result = $this->query->row("SELECT * FROM posts WHERE id = $post_id");
        foreach ($result[0] as $key => $value) $post[$key] = $value; 
        return $post;
    }

}