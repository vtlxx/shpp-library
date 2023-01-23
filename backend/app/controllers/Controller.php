<?php

namespace app\controllers;

class Controller extends \vendor\core\Controller
{
    public static function getImgName($id) : string{
        $extensions = ['jpg', 'png', 'jpeg'];
        foreach($extensions as $extension) {
            if(file_exists(IMG_PATH . "$id.$extension")) {
                return "$id.$extension";
            }
        }

        return "default.jpg";
    }
}