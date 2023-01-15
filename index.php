<?php

use vendor\core\Router;

$query = trim($_SERVER['REQUEST_URI'], '/');

spl_autoload_register(function ($class) {
    $path = 'backend/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($path)) {
        require $path;
    }
});

//setting controllers namespace for routes
Router::setControllersNamespace('app\\controllers\\');
//setting routes
//route for main page with all books
Router::add('^$', ['controller' => 'BooksPage', 'action' => 'view']);
//route for doing sth with books (add/delete)
Router::add('^admin\/api\/v2\/(?P<action>[a-z-]+)\/?(?P<id>[0-9]+)?$', ['controller' => 'AdminPage']);
//route for doing sth with books (increment clicks)
Router::add('^api\/v2\/books\/(?P<id>[0-9]+)\/(?P<action>[a-z-]+)$', ['controller' => 'BookPage']);
//route for displaying one book
Router::add('^books\/(?P<id>[0-9]+)$', ['controller' => 'BookPage', 'action' => 'view']);
//route for admin
Router::add('^admin$', ['controller' => 'AdminPage', 'action' => 'view']);


Router::route($query);

function pretty($string)
{
    echo '<pre>';
    print_r($string);
    echo '</pre><br/>';
}


