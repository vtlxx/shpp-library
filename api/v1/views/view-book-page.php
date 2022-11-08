<?php

class View{
    function __construct($contents){
        $template = 'book-page';
        include 'api/v1/templates/page-core.php';
    }
}