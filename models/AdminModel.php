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

    public function getAllPosts()
    {
        return $this->query->row('SELECT * from posts ORDER BY id DESC');
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
        $previewMini = PostImgPath . '/mini/' . $post_id . '.jpg';

        // Replace post image
        if (!empty($_FILES['image']['tmp_name'])) {
            $image = new ImageService($_FILES['image']);
            $image->loadImage($image->compress(), $preview);
            $image->loadImage($image->compress(320, 170), $previewMini);
        } 
        
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

    public function saveData($post)
    {   
        // Getting images types
        $avaType = ImageService::getImgType($_FILES['ava']['name']);
        $backgroundType = ImageService::getImgType($_FILES['background']['name']);

        $post['ava'] = !empty($_FILES['ava']['name']) ? AvatarImgPath . $avaType : $post['pre_ava'];
        $post['background'] = !empty($_FILES['background']['name']) ? BackgroundImgPath . $backgroundType : $post['pre_background'];

        if (!empty($_FILES['ava']['tmp_name'])) {
            if (file_exists($post['pre_ava'])) unlink($post['pre_ava']);
            $avatar = new ImageService($_FILES['ava']);
            $avatar->loadImage($avatar->compress(300, 300), $post['ava']);
        }
        else if (!empty($_FILES['background']['tmp_name'])) {
            if (file_exists($post['pre_background'])) unlink($post['pre_background']);
            $background = new ImageService($_FILES['background']);
            $background->loadImage($background->compress(), $post['background']);
        }

        unset($post['pre_ava']);
        unset($post['pre_background']);

        // Change data
        $file = file_get_contents('config/adminData.json');
        $data = json_decode($file, true);

        foreach ($post as $key => $value) {
            $data[$key] = trim($value);
        }

        file_put_contents('config/adminData.json', json_encode($data));
        return true;
    }

    public function postUpdatePreview($postId)
    {
        $preview = PostImgPath . $postId . '.jpg';
        $previewMini = PostImgPath . '/mini/' . $postId . '.jpg';
        
        // Load image for post
        $image = new ImageService($_FILES['image']);
        $image->loadImage($image->compress(), $preview);
        $image->loadImage($image->compress(320, 170), $previewMini);

        return $this->query->row("UPDATE posts SET preview = '$preview' WHERE id = $postId");
    }

    public function getAdminData()
    {
        return $this->data->getData();
    }

}