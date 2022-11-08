<?php

$routes = [];

add_route('', function (){});

add_route('books', function (){
    require 'controllers/controller-book-page.php';
    require 'models/model-book-page.php';
    require 'views/view-book-page.php';

    $controller = new Controller();
    $controller->start_controller();
});

add_route('admin', function (){
    require 'api/v1/admin.php';
});


/**
 * This method adds new route rule
 *
 * @param $path string name of the route
 * @param callable $callback function, that will be called, when somebody goes to this page
 */
function add_route(string $path, callable $callback){
    global $routes;
    $routes[$path] = $callback;
}

function route(){
    global $routes;
    $route_path = explode('/', $_SERVER['REQUEST_URI']);

    //looking for route with request uri path
    foreach ($routes as $path => $callback) {
        if($path === $route_path[1]) {
            $callback();
            return;
        }
    }
}