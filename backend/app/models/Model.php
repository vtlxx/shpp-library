<?php

namespace app\models;

abstract class Model extends \vendor\core\Model
{

    public function __construct()
    {
        parent::__construct();
        if(!$this->setDB('library', 'root', '', 'localhost')) {
            echo 'Database connection failed!';
        }
    }

    public function getBookAuthors(int $id) : array {
        $authors = $this->executeDB('SELECT authors.name FROM books_authors INNER JOIN authors on books_authors.author_id
                                                      = authors.id WHERE book_id = ?;', 'i', [$id]);


        return $authors;
    }

    public function getBookInfo(int $id, array $columns) : array|bool {
        return $this->executeDB('SELECT ' . implode(',', $columns) . ' FROM books WHERE id=? AND delete_date IS NULL ;', 'i', [$id])[0] ?? false;
    }

    public function getBooks(array $fields, int $pageNum, int $booksPerPage, string $orderBy, string $order) : array {
        $fields = implode(', ', $fields);
        $books = $this->executeDB("SELECT $fields FROM books WHERE delete_date IS NULL ORDER BY $orderBy $order LIMIT ?, ?",
            'ii', [max(($pageNum-1)*$booksPerPage, 0), $booksPerPage]);
        $this->totalBooks = $this->getTotalBooks();
        return $books;
    }

    public function getTotalBooks($title = null) : int{
        if(isset($title)) {
            return (int)$this->executeDB('SELECT COUNT(*) as num FROM books WHERE title LIKE ? AND delete_date IS NULL ;',
                's', ['%' . $title . '%'])[0]['num'];
        }
        return (int)$this->executeDB('SELECT COUNT(*) as num FROM books WHERE delete_date IS NULL;')[0]['num'];
    }
}