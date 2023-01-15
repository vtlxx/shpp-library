<?php

namespace vendor\core;

class Router
{
    protected static array $routes = [];
    protected static array $current = [];
    protected static string $controllersNamespace = '';

    public static function add(string $url, array $route = []): void
    {
        self::$routes[$url] = $route;
    }

    public static function get_routes(): array
    {
        return self::$routes;
    }

    public static function get_route(): array
    {
        return self::$current;
    }

    /**
     * This function marks route from routes list that matches 'url' path as the current
     *
     * @param $url string page path (url)
     * @return bool whether the route was found
     */
    public static function set_route(string $url): bool
    {
        foreach (self::$routes as $route_pattern => $route_value) {
            //if route is found - return true
            if (preg_match("#$route_pattern#i", $url, $matches)) {
                //setting parsed values (values from the url) as the current route
                foreach ($matches as $name => $value) {
                    if (is_string($name)) {
                        $route_value[$name] = $value;
                    }
                }
                self::$current = $route_value;
                return true;
            }
        }

        return false;
    }

    public static function route($query): void
    {
        //checking whether there is a route for this request
        if (self::set_route($query)) {
            $route = self::get_route();
            //checking whether controller class for this route
            if (class_exists(self::$controllersNamespace . $route['controller'])) {
                $controller = new (self::$controllersNamespace . $route['controller']);
                if (array_key_exists('id', $route)) {
                    $controller->run($route['action'], $route['id']);
                } else {
                    $controller->run($route['action']);
                }
            } else {
                echo 'Controller ' . $route['controller'] . ' not found!';
            }
        } else {
            http_response_code(404);
            require 'backend/app/errors/404.html';
        }
    }

    public static function setControllersNamespace(string $namespace): void
    {
        self::$controllersNamespace = $namespace;
    }

}