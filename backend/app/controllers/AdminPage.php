<?php

namespace app\controllers;

class AdminPage extends Controller
{

    public function __construct()
    {
        //checking is correct admin user
        if(!isset($_SERVER['PHP_AUTH_USER'])) {
            //if user isn't authorized
            header('WWW-Authenticate: Basic realm="Войдите в аккаунт!"');
            header('HTTP/1.0 401 Unauthorized');
            $view = new \app\views\ErrorPage\View;
            $view->display('401');
            exit();
        }
        if($_SERVER['PHP_AUTH_USER'] === 'logout' && $_SERVER['PHP_AUTH_PW'] === 'logout') {
            header('HTTP/1.0 401 Unauthorized');
            exit();
        }
        $isAdmin = $this->isCorrectAdmin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        if(!$isAdmin) {
            //if user incorrect admin
            header('HTTP/1.0 403 Forbidden');
            header('WWW-Authenticate: Basic realm="Неверный логин/пароль"');
            $view = new \app\views\ErrorPage\View;
            $view->display('403');
            exit();
        }
    }

    public function viewAction(): void
    {
        //GETTING CONTENT FROM DATABASE
        $model = new \app\models\AdminPage();
        //setting table page (default is 1)
        $tablePage = array_key_exists('page', $_GET) && isset($_GET['page']) && is_numeric($_GET['page'])
            ? (int)$_GET['page'] : 1;
        $totalBooks = $model->getTotalBooks();
        //getting books for current page
        $totalPages = ceil($totalBooks/BOOKS_PER_PAGE_ADMIN);
        $content = $model->getBooks(['id', 'title', 'year', 'views', 'clicks'], $totalPages-$tablePage+1, BOOKS_PER_PAGE_ADMIN, 'id', 'ASC');
        foreach ($content as &$book) {
            $book['author'] = implode(', ', array_column($model->getBookAuthors($book['id']), 'name'));
        }

        //DISPLAYING CONTENT
        $view = $this->initView();
        $view->setPaginationSettings($tablePage, $totalPages);
        $view->display($content);
    }

    public function addAction() : void
    {
        if(!(array_key_exists('title', $_POST) && array_key_exists('description', $_POST) &&
            array_key_exists('authors', $_POST) && array_key_exists('pages', $_POST) &&
            array_key_exists('year', $_POST) && array_key_exists('bookimage', $_FILES))) {
            http_response_code(400);
            echo json_encode(['error' => 'not all parameters passed']);
            exit();
        }
        $data = $_POST;
        //parsing authors string
        $data['authors'] = explode(';', $data['authors']);

        $model = new \app\models\AdminPage();
        $model->addBook($data, $_FILES);
    }

    public function refreshAction() : void
    {
        $model = new \app\models\AdminPage();
        //setting table page (default is 1)
        $tablePage = array_key_exists('page', $_GET) && isset($_GET['page']) && is_numeric($_GET['page'])
            ? (int)$_GET['page'] : 1;
        $totalBooks = $model->getTotalBooks();
        //getting books for current page
        $totalPages = ceil($totalBooks/BOOKS_PER_PAGE_ADMIN);
        $content = $model->getBooks(['id', 'title', 'year', 'views', 'clicks'], $totalPages-$tablePage+1, BOOKS_PER_PAGE_ADMIN, 'id', 'ASC');
        foreach ($content as &$book) {
            $book['author'] = implode(', ', array_column($model->getBookAuthors($book['id']), 'name'));
        }

        $view = $this->initView();
        $result = $view->getTable($content) . $view->getPagination($tablePage, $totalPages);
        echo $result;
    }

    public function deleteAction(): void
    {
        $model = new \app\models\AdminPage();
        $model->deleteBook((int)$this->route['id']);
        echo json_encode(['ok' => true]);
    }

    private function isCorrectAdmin(string $login, string $pass) : bool
    {
        $model = new \app\models\AdminPage();
        $result = $model->executeDB('SELECT COUNT(1) as count FROM admins WHERE login=? AND password=?;',
            'ss', [$login, $pass]);
        return $result[0]['count'] > 0;
    }
}