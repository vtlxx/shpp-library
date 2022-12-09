<?php
class Controller_Admin
{
    private int $total_books;
    private const BOOKS_PER_PAGE = 10;
    public function start_controller(): void
    {
        $action = explode('/', $_SERVER['REQUEST_URI']);
        $model = new Model_Admin();
        $view = new View_Admin();

        //if it's request to add a book
        if(array_key_exists(2, $action)) {
            if($action[2]==='add') {
                $data = $_POST;
                //parsing authors string
                $data['authors'] = explode(';', $data['authors']);

                $model->add_book($data, $_FILES);
            }
            elseif($action[2]==='refresh'){
                //parsing authors string
                $this->total_books = $model->get_total_books();
                $contents = $model->get_books_in_range(1, self::BOOKS_PER_PAGE,
                    $this->total_books, ceil($this->total_books/self::BOOKS_PER_PAGE));
                $view->set_total_pages(ceil($this->total_books/self::BOOKS_PER_PAGE));
                $view->refresh_table($contents);
            }
            elseif(substr($action[2], 0, strpos($action[2], '?'))==='delete') {
                $model->delete($_GET['id']);
            }
        }
        //if it's request to show admin page
        else {
            $this->total_books = $model->get_total_books();
            $contents = $model->get_books_in_range($_GET['page'], self::BOOKS_PER_PAGE,
                $this->total_books, ceil($this->total_books/self::BOOKS_PER_PAGE));
            $view->set_total_pages(ceil($this->total_books/self::BOOKS_PER_PAGE));
            $view->display($contents);
        }
    }
}