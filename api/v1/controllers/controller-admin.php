<?php
class Controller_Admin
{

    function start_controller(): void
    {
        $model = new Model_Admin();
        $contents = $model->get_all_books();
        $view = new View_Admin($contents);
    }
}