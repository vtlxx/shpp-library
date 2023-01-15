<?php

namespace app\controllers;

class BooksPage extends \vendor\core\Controller
{

    public function start_controller(): void
    {
        $model = new Model_Books();
        $view = new View_Books();

        $page = 1;
        $books_per_page = 20;
        $search = '';
        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
        }
        if (isset($_GET['offset']) && $_GET['offset'] < 20) {
            $books_per_page = (int)$_GET['offset'];
        }
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        }

        $contents = $model->get_books($page, $books_per_page, $search);
        $books_count = $model->get_total_books_count();
        $max_page = ceil($books_count / (double)$books_per_page);
        $is_first = $page <= 1;
        $is_last = $page >= $max_page;
        $view->display($contents, $is_first, $is_last, $page, $search, $books_per_page);
    }

    public function viewAction(): void
    {
        echo '<b>BooksPage::viewAction()</b>';
    }
}
