<?php

use core\Model;
use services\ImageService;

class AdminModel extends Model
{

    public function getLogs()
    {
        if (file_exists(PathLogs)) {
            return $logs = array_reverse(explode('|', file_get_contents(PathLogs)));
        }
    }

    public function getLimitedPosts($limit = 0, $page = 1)
    {
        $range = $limit * ($page - 1);
        return $this->query->row("SELECT * FROM posts ORDER BY id DESC LIMIT $range, $limit");
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

    public function getLastPostId()
    {
        return $this->query->column("SELECT MAX(id) FROM posts");
    }

    public function postUpdate($post_id, $post)
    {   
        $title = htmlentities(trim($post['title']));
        $desc = htmlentities(trim($post['description'])); 
        $preview = PostImgPath . $post_id . '.jpg';
        
        $this->query->row("UPDATE posts SET title = '$title', descript = '$desc', preview = '$preview' WHERE id = $post_id");
        return true;
    }   

    public function postAdd($post)
    {
        $title = htmlentities(trim($post['title']));
        $desc = htmlentities(trim($post['description']));
        $preview = PostImgPath;
        
        $this->query->row("INSERT INTO posts (title, descript, preview) VALUES('$title', '$desc', '$preview')");
        return true;
    }

    public function deletePost($postId)
    {
        return $this->query->row("DELETE FROM posts WHERE id = $postId");
    }

    public function removePostImage($id)
    {
        $images = [
            'max' => PostImgPath . $id . '.jpg',
            'mini' => PostImgPath . '/mini/' . $id . '.jpg'
        ];
        foreach ($images as $image) if (file_exists($image)) unlink($image);
        return;
    }

    public function saveData($post)
    {   
        // Getting images types
        $avaType = ImageService::getImgType($_FILES['ava']['name']);

        $post['ava'] = !empty($_FILES['ava']['tmp_name']) ? AvatarImgPath . $avaType : $post['pre_ava'];
        $post['background'] = !empty($_FILES['background']['tmp_name']) ? BackgroundImgPath . 'jpg' : $post['pre_background'];

        if (!empty($_FILES['ava']['tmp_name'])) {
            $this->profileUploadImage($_FILES['ava'], 'avatar');
        }
        if (!empty($_FILES['background']['tmp_name'])) {
            $this->profileUploadImage($_FILES['background'], 'background');
        }

        unset($post['pre_ava']);
        unset($post['pre_background']);

        // Change data
        $this->data->updateData($post);
        return;
    }

    public function postUpdatePreview($postId)
    {
        $preview = PostImgPath . $postId . '.jpg';
        return $this->query->row("UPDATE posts SET preview = '$preview' WHERE id = $postId");
    }

    public function getAdminData()
    {
        return $this->data->getData();
    }

    public function postUploadImage($image, $id)
    {
        $path = PostImgPath . $id . '.jpg';
        $preview = new ImageService($image);
        $preview->loadImage($preview->compress(), $path);
        $preview->loadImage($preview->compress(320, 180), PostImgPath . '/mini/' . $id . '.jpg');
    }

    public function profileUploadImage($image, $type)
    {
        $img = new ImageService($image);
        switch ($type) {
            case 'avatar': $img->loadImage($img->compress(300, 300), AvatarImgPath . $img->getType());
                break;
            case 'background': $img->loadImage($img->compress(), BackgroundImgPath . 'jpg');
                break;
        }
    }

    public function updatePassword($newPassword)
    {
        $params = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];
        $this->data->updateData($params);
        return;
    }

}