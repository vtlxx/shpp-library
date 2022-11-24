<?php
class Controller_Admin
{

    function start_controller(): void
    {
        $action = explode('/', $_SERVER['REQUEST_URI']);
        $model = new Model_Admin();

        //if it's request to add a book
        if(array_key_exists(2, $action) && $action[2]==='add') {
            $data = json_decode(file_get_contents('php://input'), true);
            //parsing authors string
            $data['authors'] = explode(';', $data['authors']);

            $model->add_book($data);
        }
        //if it's request to show admin page
        else {
            $contents = $model->get_all_books();
            $view = new View_Admin($contents);
        }
    }
}