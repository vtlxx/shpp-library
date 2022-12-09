<?php
class Controller
{

    function start_controller(): void
    {
        $book_id = explode('/', $_SERVER['REQUEST_URI'])[2];
        $model = new Model();
        $contents = $model->get_info_by_id((int)$book_id);

        $view = new View();
        //if book does not exist
        if(is_array($contents)) {
            $view->display($contents);
        }
        else {
            //displaying error page
            $view->error($contents);
        }
    }
}