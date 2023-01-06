<?php

class View_Books {
    function display($contents, $is_first, $is_last, $page, $search, $books_per_page) {
        $link_prev = 'http://library.local/';
        $link_next = 'http://library.local/';
        $link_prev .= '?page=' . $page - 1;
        $link_next .= '?page=' . $page + 1;
        if($search !== '') {
            $link_prev .= '&search=' . $search;
            $link_next .= '&search=' . $search;
        }
        $link_prev .= '&offset=' . $books_per_page;
        $link_next .= '&offset=' . $books_per_page;

        if($is_first) {
            $link_prev = '#';
        }
        if($is_last) {
            $link_next = '#';
        }
        $template = 'books-page';
        include 'api/v1/templates/page-core.php';
    }

    function error($error) {
        include 'api/v1/errors/' . $error . '.html';
    }
}