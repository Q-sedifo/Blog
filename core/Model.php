<?php

namespace core;

use core\QueryBuilder;
use core\AdminManager;

abstract class Model 
{

    public $query;
    public $data;

    public function __construct()
    {
        $this->query = new QueryBuilder;
        $this->data = AdminManager::getInstance();
    }

}