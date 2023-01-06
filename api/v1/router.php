<?php

$routes = [];

add_route('', function (){
    require 'controllers/controller-books-page.php';
    require 'models/model-books-page.php';
    require 'views/view-books-page.php';

    $controller = new Controller_Books();
    $controller->start_controller();
});

add_route('books', function (){
    require 'controllers/controller-book-page.php';
    require 'models/model-book-page.php';
    require 'views/view-book-page.php';

    $controller = new Controller();
    $controller->start_controller();
});

add_route('admin', function (){
    if(true) {
//    require 'controllers/controller-admin.php';
//    require 'models/model-admin.php';
//    require 'views/view-admin.php';
//    $controller = new Controller_Admin();
//    $controller->start_controller();
    } else {
        require 'controllers/controller-login.php';
        require 'models/model-login.php';
        require 'views/views-login.php';
    }

});


/**
 * This method adds new route rule
 *
 * @param $path string name of the route
 * @param callable $callback function, that will be called, when somebody goes to this page
 */
function add_route(string $path, callable $callback): void
{
    global $routes;
    $routes[$path] = $callback;
}

function route(): void
{
    global $routes;
    $route_path = '';
    if(str_contains($_SERVER['REQUEST_URI'], '?')) {
        $route_path = explode('/', substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')));
    }
    else {
        $route_path = explode('/', $_SERVER['REQUEST_URI']);
    }
    //looking for route with request uri path
    foreach ($routes as $path => $callback) {
        if($path === $route_path[1]) {
            $callback();
            return;
        }
    }
}