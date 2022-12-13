<?php
class Controller_Books {
    public function start_controller() : void {
        $model = new Model_Books();
        $view = new View_Books();

        $page = 1;
        $books_per_page = 20;
        $search = '';
        if(isset($_GET['page'])) {
            $page = (int)$_GET['page'];
        }
        if(isset($_GET['offset']) && $_GET['offset'] < 20) {
            $books_per_page = (int)$_GET['offset'];
        }
        if(isset($_GET['search'])) {
            $search = $_GET['search'];
        }

        $view->display($model->get_books($page, $books_per_page, $search));
    }
}
