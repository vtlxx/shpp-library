<?php
require 'database/connect_db.php';
$routes = [];

add_route('', function (){
    require 'controllers/BooksPage.php';
    require 'models/model-books-page.php';
    require 'views/view.php';

    $controller = new Controller_Books();
    $controller->start_controller();
});

add_route('books', function (){
    require 'controllers/BookPage.php';
    require 'models/model-book-page.php';
    require 'views/view.php';

    $controller = new Controller();
    $controller->start_controller();
});

add_route('admin', function (){
    //checking authorization
    if(isset($_SERVER['PHP_AUTH_USER'])) {
        //if request for logout
//        if(!empty(file_get_contents('php://input')) &&
//            array_key_exists('logout', json_decode(file_get_contents('php://input'), true))) {
//            //print_r($_SESSION);
//            header( "WWW-Authenticate: Basic realm=\"Test Authentication System\"");
//            header( "HTTP/1.0 401 Unauthorized");
//            exit();
//        }
        if($_SERVER['PHP_AUTH_USER'] === 'logout' && $_SERVER['PHP_AUTH_PW'] === 'logout') {
            echo 'trueee';
            header('HTTP/1.0 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Password protected"');
        }
        //checking is password right
        else if(is_correct_admin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
            require 'controllers/AdminPage.php';
            require 'models/model-admin.php';
            require 'views/view.php';
            $controller = new Controller_Admin();
            $controller->start_controller();
        } else {
            require('errors/403.html');
            header('HTTP/1.0 403 Forbidden');
            header('WWW-Authenticate: Basic realm="Неверный логин/пароль"');
        }
    } else {
        //if user isn't authorized
        header('WWW-Authenticate: Basic realm="Войдите в аккаунт!"');
        header('HTTP/1.0 401 Unauthorized');
        require 'errors/401.html';
    }
});

add_route('logout', function (){
    header('HTTP/1.0 401 Unauthorized');
    //require 'errors/401.html';
});

function is_correct_admin($login, $pass) : bool {
    $mysql = connect_db();
    $stmt = $mysql->prepare('SELECT COUNT(1) FROM admins WHERE login=? AND password=?;');
    $stmt->bind_param('ss', $login, $pass);
    $stmt->execute();
    return $stmt->get_result()->fetch_all()[0][0] > 0;
}

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