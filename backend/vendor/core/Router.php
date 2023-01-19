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

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        return self::$current;
    }

    /**
     * This function marks route from routes list that matches 'url' path as the current
     *
     * @param $url string page path (url)
     * @return bool whether the route was found
     */
    public static function setRoute(string $url): bool
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
        $query = self::clearGetParams($query);
        //checking whether there is a route for this request
        if (self::setRoute($query)) {
            $route = self::getRoute();
            //checking whether controller class for this route
            if (class_exists(self::$controllersNamespace . $route['controller'])) {
                $controller = new (self::$controllersNamespace . $route['controller']);
                $controller->run($route);
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

    protected static function clearGetParams($query) : string{
        if($query && strpos($query, '?')) {
            return trim(substr($query, 0, strpos($query, '?')), '/');
        }

        return $query;
    }
}