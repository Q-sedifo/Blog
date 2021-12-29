<?php

namespace core;
use core\QueryBuilder;

abstract class Model 
{

    public $query;
    public $error = false;

    public function __construct()
    {
        $this->query = new QueryBuilder;
    }

    public function getAdminData($password = false)
    {
        $data = require AdminData;

        // Ckeck premission for getting admin password
        if ($password) return $data;
        else {
            foreach ($data as $key => $value) {
                if ($key != 'password') $admin[$key] = $value; 
            }
            return $admin;
        }
    }


}