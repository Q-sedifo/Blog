<?php

namespace services;

class CodeGeneratorService 
{
    static $chars = ['a', 'B', 'c', 'G', 'v', 't', 'K', 'd', 'y', 'N', 'h'];

    static public function createCode() 
    {
        $first = mt_rand(1, 10);
        $second = mt_rand(1, 10);
        $code = self::$chars[mt_rand(1, 10)] . $first . self::$chars[mt_rand(1, 10)] . $second . self::$chars[mt_rand(1, 10)];
        return $code;
    }
}
