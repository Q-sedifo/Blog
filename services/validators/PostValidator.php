<?php

namespace services\validators;

use core\FormHelper;
use services\ImageService;

class PostValidator extends FormHelper 
{

    private $fields = ['title', 'description'];
    private $type;
    
    public function __construct($post, $type)
    {
        parent::__construct($this->fields, $post);
        $this->type = $type;
        $this->checkFields();
    }

    private function checkFields()
    {
        $this->checkTitle();
        $this->checkDescription();
        $this->checkImage();
    }

    private function checkTitle()
    {
        $title = $this->post['title'];

        if (empty($title)) {
            $this->addError('Fill title');
        }
        else if (iconv_strlen($title) > 32) {
            $this->addError('Too long title');
        }
    }

    private function checkDescription()
    {
        $description = $this->post['description'];

        if (empty($description)) {
            $this->addError('Fill description');
        }
        else if (iconv_strlen($description) > 1000) {
            $this->addError('Too long description');
        }
    }

    private function checkImage()
    {
        $image = $_FILES['image'];

        if ($this->type == 'add') {
            if (empty($image['tmp_name'])) {
                $this->addError('Select image');
            }
        }

        if (!empty($image['tmp_name']) && !ImageService::imgTypeValidate($image['name'])) {
            $this->addError('Incorrect image type');
        }

        if (!empty($image['tmp_name']) && ImageService::getImgType($image['name']) !== 'jpg') {
            $this->addError('JPG image type only');
        }
    }

}