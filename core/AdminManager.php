<?php

namespace core;

class AdminManager
{

    const FILE = 'config/adminData.json';
    static private $_instance;
    static private $data;
    static private $password;

    private function __construct() {}
    private function __clone() {}

    // Singleton pattern
    static public function getInstance() 
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }

        $result = self::extractData();

        foreach ($result as $key => $value) {
            if ($key != 'password') {
                self::$data[$key] = $value;
            }
            else self::$password = $value;
        }
        
        return self::$_instance = new self;
    }

    public function getData($prop = false)
    {
        if ($prop) return self::$data[$prop];
            return self::$data;
    }

    static public function getPassword()
    {
        return self::$password;
    }

    // Extracting data from json file
    static private function extractData()
    {
        return $data = json_decode(file_get_contents(self::FILE), true);
    }

}