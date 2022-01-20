<?php

namespace core;

abstract class FormHelper
{

    private $error = null;
    private $fields;
    protected $post;

    public function __construct($fields, $post)
    {
        $this->fields = $fields;
        $this->post = $post;
        $this->validateForm();
    }

    private function validateForm()
    {
        foreach ($this->fields as $field) {
            if (!array_key_exists($field, $this->post)) {
                trigger_error("$field doesn't exists");
                exit();
            }
        }
    }

    protected function addError($error)
    {
        $this->error[] = $error;
    }

    public function getError()
    {
        return $this->error[0];
    }

    public function checkError() : bool
    {
        if ($this->error) return false;
            return true;
    }

}