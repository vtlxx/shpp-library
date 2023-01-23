<?php
namespace app\models;

class BooksPage extends Model
{
    public int $totalBooks;

    public function getBooksByTitle($pageNum, $booksPerPage, $orderBy, $title): array
    {
        $books = $this->executeDB("SELECT id, title, year FROM books WHERE title LIKE ? AND delete_date IS NULL ORDER BY $orderBy DESC LIMIT ?, ?",
            'sii', ['%' . $title . '%', ($pageNum - 1) * $booksPerPage, $booksPerPage]);
        $this->totalBooks = $this->getTotalBooks($title);
        return $books;
    }
}