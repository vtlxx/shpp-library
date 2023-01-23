<?php

namespace app\views\ErrorPage;

class View extends \app\views\View
{

    public function display($code): void
    {
        $this->requireHeader();
        require VIEWS_PATH . "/templates/Errors/$code.php";
    }
}