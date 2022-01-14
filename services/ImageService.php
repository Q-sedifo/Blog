<?php

namespace services;

class ImageService 
{

    static public function getImgType($file)
    {
        $str = explode('.', $file);
        return $type = end($str);
    }

    static public function imgTypeValidate($image)
    {
        global $imgTypes;

        $type = self::getImgType($image);
        if (!in_array($type, $imgTypes)) return false;
        return true;
    }

}