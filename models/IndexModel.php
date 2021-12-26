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

}