<?php

namespace app\controllers;

class BookPage extends \vendor\core\Controller
{

    function start_controller(): void
    {
        $model = new Model();

        if (isset($_GET['click'])) {
            $model->increment_click($_GET['click']);
        } else {
            $book_id = explode('/', $_SERVER['REQUEST_URI'])[2];
            $contents = $model->get_info_by_id((int)$book_id);

            $view = new View();
            //if book does not exist
            if (is_array($contents)) {
                $view->display($contents);
            } else {
                //displaying error page
                $view->error($contents);
            }
        }
    }

    public function viewAction($id): void
    {
        echo "<b>BookPage::viewAction()</b>";
    }

    public function clickAction($id): void
    {
        echo "<b>BookPage::clickAction()</b>";
    }
}