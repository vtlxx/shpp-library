<?php

namespace app\controllers;

class BooksPage extends Controller
{

//    public function start_controller(): void
//    {
//        $model = new Model_Books();
//        $view = new View_Books();
//
//        $page = 1;
//        $books_per_page = 20;
//        $search = '';
//        if (isset($_GET['page'])) {
//            $page = (int)$_GET['page'];
//        }
//        if (isset($_GET['offset']) && $_GET['offset'] < 20) {
//            $books_per_page = (int)$_GET['offset'];
//        }
//        if (isset($_GET['search'])) {
//            $search = $_GET['search'];
//        }
//
//        $contents = $model->get_books($page, $books_per_page, $search);
//        $books_count = $model->get_total_books_count();
//        $max_page = ceil($books_count / (double)$books_per_page);
//        $is_first = $page <= 1;
//        $is_last = $page >= $max_page;
//        $view->display($contents, $is_first, $is_last, $page, $search, $books_per_page);
//    }

    public function viewAction(): void
    {
        /*  TODO: getting content from model
         *  getting only books, that need to be displayed
         *  so, first, need to count they by pagination
         */

        $model = new \app\models\BooksPage;
        //setting current page num
        $pageNum = (int)(array_key_exists('page', $_GET) && isset($_GET['page']) ? $_GET['page'] : 1);
        //getting info about books for current page
        if(array_key_exists('search', $_GET) && isset($_GET['search'])) {
            $content = $model->getBooksByTitle($pageNum, BOOKS_PER_PAGE, 'views', $_GET['search']);
        }
        else {
            $content = $model->getBooks(['id', 'title', 'year'], $pageNum, BOOKS_PER_PAGE, 'views', 'DESC');
        }
        //adding author field
        foreach ($content as &$book) {
            $book['imgName'] = $this->getImgName($book['id']);
            $book['author'] = implode(', ', array_column($model->getBookAuthors($book['id']), 'name'));
        }

        $view = $this->initView();
        //getting info for pagination
        $isFirst = $pageNum === 1;
        $isLast = $pageNum*BOOKS_PER_PAGE >= $model->getTotalBooks();

        $view->setPagination($pageNum, $isFirst, $isLast);
        //displaying content
        $view->display($content);
    }

    /**
     * @param int $pageNum
     * @param int $booksPerPage
     * @param int $booksNum
     * @return array {[from] = first index of range; [to] = last index of range}
     */
    private function getPaginationInfo(int $pageNum, int $booksPerPage, int $booksNum) : array {
        $result['from'] = ($pageNum-1)*$booksPerPage+1;
        $result['to'] = min($pageNum * $booksPerPage, $booksNum);


        $result['isFirst'] = $result['to'] === 0;
        $result['isLast'] = $result['to'] === $booksNum;

        return $result;
    }
}
