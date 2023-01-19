<?php

namespace app\controllers;

class Controller extends \vendor\core\Controller
{
    protected function getImgName($id) : string{
        $extensions = ['jpg', 'png', 'jpeg'];
        foreach($extensions as $extension) {
            if(file_exists(IMG_PATH . "/$id.$extension")) {
                return "$id.$extension";
            }
        }

        return IMG_PATH . "/default.jpg";
    }
}