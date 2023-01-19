<?php

namespace vendor\core;

abstract class Controller
{
    protected array $route;

    public function run($route) : void
    {
        $this->route = $route;
        $actionFunction = $route['action'] . 'Action';
        if (method_exists($this, $actionFunction)) {
            $this->$actionFunction();
        } else {
            echo "Функция <b>$actionFunction</b> не найдена!";
        }
    }

    public function initView() {
        return new (VIEWS_NAMESPACE . '\\' . $this->route['controller'] . '\\View')($this->route['controller'], $this->route['action']);
    }
}