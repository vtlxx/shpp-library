<?php

namespace vendor\core;

abstract class View
{
    protected string $template;
    protected string $layout;
    //matching action to layout
    protected array $templates = ['view' => 'default', 'refresh' => 'none'];

    public function __construct($template, $action)
    {
        $this->template = $template;
        $this->layout = $this->templates[$action];
    }

    public function display($content) : void {
        $this->requireHeader();
        require APP_PATH . "/views/templates/{$this->template}/{$this->layout}.php";
        $this->requireFooter();
    }

    protected function requireHeader() : void {
        require APP_PATH . "/views/templates/core/header.php";
    }

    protected function requireFooter() : void {
        require APP_PATH . "/views/templates/core/footer.php";
    }
}