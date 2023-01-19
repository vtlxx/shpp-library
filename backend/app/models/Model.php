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
        return $this->executeDB('SELECT ' . implode(',', $columns) . ' FROM books WHERE id=?;', 'i', [$id])[0];
    }
}