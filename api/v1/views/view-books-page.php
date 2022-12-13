<?php

class View_Books {
    function display($contents) {
        $template = 'books-page';
        include 'api/v1/templates/page-core.php';
    }

    function error($error) {
        include 'api/v1/errors/' . $error . '.html';
    }
}