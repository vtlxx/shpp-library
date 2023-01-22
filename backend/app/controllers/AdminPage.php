<?php

namespace app\controllers;

class AdminPage extends Controller
{
//    public function start_controller(): void
//    {
//        $action = explode('/', $_SERVER['REQUEST_URI']);
//        $model = new Model_Admin();
//        $view = new View_Admin();
//
//        //if it's request to add a book
//        if (array_key_exists(2, $action)) {
//            if ($action[2] === 'add') {
//                $data = $_POST;
//                //parsing authors string
//                $data['authors'] = explode(';', $data['authors']);
//
//                $model->add_book($data, $_FILES);
//            } elseif ($action[2] === 'refresh') {
//                //parsing authors string
//                $this->total_books = $model->get_total_books();
//                $contents = $model->get_books_in_range(1, self::BOOKS_PER_PAGE,
//                    ceil($this->total_books / self::BOOKS_PER_PAGE));
//                $view->set_total_pages(ceil($this->total_books / self::BOOKS_PER_PAGE));
//                $view->refresh_table($contents);
//            } elseif (substr($action[2], 0, strpos($action[2], '?')) === 'delete') {
//                $model->delete($_GET['id']);
//            }
//        } //if it's request to show admin page
//        else {
//            $this->total_books = $model->get_total_books();
//            $page = array_key_exists('page', $_GET) ? $_GET['page'] : 1;
//            $contents = $model->get_books_in_range($page, self::BOOKS_PER_PAGE,
//                ceil($this->total_books / self::BOOKS_PER_PAGE));
//            $view->set_total_pages(ceil($this->total_books / self::BOOKS_PER_PAGE));
//            $view->display($contents);
//        }
//    }

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
        if($model->deleteBook((int)$this->route['id']) !== false) {
            //deleting image of the book
            $imgName = $this->getImgName($this->route['id']);
            if($imgName !== DEFAULT_IMG) {
                unlink(IMG_PATH . $imgName);
            }
            echo json_encode(['ok' => true]);
        }
        else {
            http_response_code(404);
            echo json_encode(['error' => 'delete went wrong!']);
        }

    }
}