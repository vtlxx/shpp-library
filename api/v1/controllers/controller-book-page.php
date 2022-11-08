<?php
class Controller
{

    function start_controller(): void
    {
        $book_id = explode('/', $_SERVER['REQUEST_URI'])[2];
        $model = new Model();
        $contents = $model->get_info_by_id($book_id);
        $view = new View($contents);
    }
}