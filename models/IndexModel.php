<?php

use core\Model;

class IndexModel extends Model
{

    public function getCardPosts($limit = 0, $page = 1)
    {
        $range = $limit * ($page - 1);
        return $this->query->row("SELECT id, title, datatime FROM posts ORDER BY id DESC LIMIT $range, $limit");
    }

    public function getPostsAmount()
    {
        return $this->query->column('SELECT COUNT(id) as amount FROM posts');
    }

    public function getPostById($id)
    {
        $post = $this->query->row("SELECT * FROM posts WHERE id = $id");
        return $post[0];
    }   

    public function saveLog()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $logs = file_get_contents(PathLogs);
        $logs .= $ip . '[' . date('Y-m-d, H:i') . ']' . '|';
        file_put_contents(PathLogs, $logs);
    }

    public function getAdminData()
    {
        return $this->data->getData();
    }

    public function searchPosts($title)
    {
        $title = htmlentities($title);
        return $this->query->row("SELECT id, title, datatime FROM posts WHERE title LIKE '%$title%'");
    }

    public function getRecomendedPosts()
    {
        $ids = $this->getAllPostsId();
        $amount = count($ids) - 1;
        $first = $ids[mt_rand(0, $amount)]['id'];
        $second = $ids[mt_rand(0, $amount)]['id'];
        return $this->query->row("SELECT id, title, datatime FROM posts WHERE id in($first, $second)");
    }

    public function getAllPostsId()
    {
        return $this->query->row("SELECT id FROM posts");
    }

}