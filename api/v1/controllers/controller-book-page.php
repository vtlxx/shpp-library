<?php
class Controller
{

    function start_controller(): void
    {
        $model = new Model();

        if(isset($_GET['click'])) {
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
}