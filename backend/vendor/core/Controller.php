<?php

namespace vendor\core;

abstract class Controller
{
    private string $action;
    private ?int $id;

    public function run($action = 'view', $id = null): void
    {
        $this->action = $action;
        $this->id = $id;
        echo get_class($this) . "::run($this->action, $this->id)<br/>";
        $action .= 'Action';
        if (method_exists($this, $action)) {
            if (isset($id)) {
                $this->$action($id);
            } else {
                $this->$action();
            }
        } else {
            echo "Функция <b>$action</b> не найдена!";
        }
    }
}