<?php

class View{
    function display($contents) {
        $template = 'book-page';
        include 'api/v1/templates/page-core.php';
    }

    function error($error) {
        include 'api/v1/errors/' . $error . '.html';
    }
}