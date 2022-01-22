<?php

namespace services;

class ImageService 
{
    const DEFAULT_WIDTH = D_IMG_WIDTH;
    const DEFAULT_HEIGHT = D_IMG_HEIGHT;
    private $image;
    private $type;

    public function __construct($image)
    {
        $this->image = $image;
        $this->type = self::getImgType($image['name']);
    }

    public function getType()
    {
        return $this->type;
    }

    public function loadImage($img, $path)
    {
        switch ($this->type) {
            case 'jpg': imagejpeg($img, $path);
                break;
            case 'jpeg': imagejpeg($img, $path);
                break;
            case 'png': imagepng($img, $path);
                break;
            case 'gif': imagegif($img, $path);
                break;
            default: trigger_error('Incorrect image type');
        }

        imagedestroy($img);
        return true;
    }

    public function compress($width = self::DEFAULT_WIDTH, $height = self::DEFAULT_HEIGHT)
    {
        $type = $this->type;
        $image = $this->image['tmp_name'];

        switch ($type) {
            case 'jpg': $img = imagecreatefromjpeg($image);
                break;
            case 'jpeg': $img = imagecreatefromjpeg($image);
                break;
            case 'png': $img = imagecreatefrompng($image);
                break;
            case 'gif': $img = imagecreatefromgif($image);
                break;
            default: trigger_error('Incorrect image type');
        }

        $size = getimagesize($image);

        $imgWidth = $size['0'];
        $imgHeight = $size['1'];

        $newWidth = $width;
        $newHeight = $height;

        $newImg = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $imgWidth, $imgHeight);
        imagedestroy($img);

        return $newImg;
    }

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