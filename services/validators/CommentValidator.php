<?php

namespace services\validators;

use core\FormHelper;

class CommentValidator extends FormHelper
{

    private $fields = ['name', 'text'];

    public function __construct($post)
    {
        parent::__construct($this->fields, $post);
        $this->checkFields();
    }

    private function checkFields()
    {
        $this->checkName();
        $this->checkComment();
    }

    private function checkName()
    {
        $name = $this->post['name'];

        if (empty($name)) {
            $this->addError('Input name');
        }
        else if (iconv_strlen($name) < 2) {
            $this->addError('Too short name');
        }
        else if (iconv_strlen($name) > 12) {
            $this->addError('Too long name');
        }
    }

    private function checkComment()
    {
        $comment = $this->post['text'];

        if (empty($comment)) {
            $this->addError('Input comment');
        }
        else if (iconv_strlen($comment) > 100) {
            $this->addError('Too long comment');
        }
    }

}