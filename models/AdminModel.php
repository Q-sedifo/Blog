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

    public function postValidate($post, $type)
    {  
        $title = iconv_strlen($post['title']);
        $description = iconv_strlen($post['description']);
        $image = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : null;

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
        else if ($image) {
            if (!ImageService::imgTypeValidate($image)) {
                $this->error = 'Incorrect image type';
            }
        }

        if ($this->error) return false;
            else return true;
    }

    public function adminDataValidate($post)
    {
        $name = iconv_strlen($post['name']);
        $email = $post['email'];
        $bio = iconv_strlen($post['bio']);
        $ava = $_FILES['ava']['name'];
        $background = $_FILES['background']['name'];

        if ($name <= 0 || $name > 32) {
            $this->error = 'Incorrect name';
        }
        else if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Incorrect email';
        }
        else if ($bio <= 10 || $bio > 1000) {
            $this->error = 'Bio must contain from 10 to 1000 letters';
        } 
        if ($ava) {
            if (!ImageService::imgTypeValidate($ava)) {
                $this->error = 'Incorrect ava image type';
            }
        }
        if ($background) {
            if (!ImageService::imgTypeValidate($background)) {
                $this->error = 'Incorrect background image type';
            }
        }

        if ($this->error) return false;
            else return true;
    }

    public function postUpdate($post_id, $post)
    {
        $title = htmlentities(trim($post['title']));
        $desc = htmlentities(trim($post['description'])); 

        $imgType = ImageService::getImgType($post['preview']);
        $preview = PostImgPath . $post_id . '.' . $imgType;

        // Replace post image
        if (!empty($_FILES['image']['tmp_name'])) {
            if (file_exists($post['pre_preview'])) unlink($post['pre_preview']);
            move_uploaded_file($_FILES['image']['tmp_name'], $preview);
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
            move_uploaded_file($_FILES['ava']['tmp_name'], $post['ava']);
        }
        else if (!empty($_FILES['background']['tmp_name'])) {
            if (file_exists($post['pre_background'])) unlink($post['pre_background']);
            move_uploaded_file($_FILES['background']['tmp_name'], $post['background']);
        }

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
        $imgType = ImageService::getImgType($_FILES['image']['name']);
        $preview = PostImgPath . $postId . '.' . $imgType;

        // Load image for post
        move_uploaded_file($_FILES['image']['tmp_name'], $preview);
        return $this->query->row("UPDATE posts SET preview = '$preview' WHERE id = $postId");
    }

}