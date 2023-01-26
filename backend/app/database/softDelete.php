<?php

const IMG_PATH = '/usr/local/var/www/library/static/books-img/';
const extensions = ['jpg', 'png', 'jpeg'];

$mysql = new mysqli('localhost', 'root', '', 'library');
$result = $mysql->query('SELECT id FROM books WHERE delete_date<now();');
$result = $result->fetch_all(MYSQLI_ASSOC);
foreach ($result as $book) {
    //finding authors, that linked with this book
    $authors = $mysql->query("SELECT author_id as id FROM books_authors WHERE book_id={$book['id']};");
    $authors = $authors->fetch_all(MYSQLI_ASSOC);
    //getting only those authors, who linked only to this book
    foreach ($authors as $author)
    {
        //checking other connections for this author
        $otherBooks = $mysql->query("SELECT COUNT(1) as count FROM books_authors 
                         WHERE author_id={$author['id']} AND book_id!={$book['id']};");
        $otherBooks = $otherBooks->fetch_all(MYSQLI_ASSOC);
        //if this book is only link for the author - delete him
        if($otherBooks[0]['count'] == 0) {
            $mysql->query("DELETE FROM authors WHERE id={$author['id']};");
        }
    }
    //deleting book and returning result (links will be deleted automatically)
    $mysql->query("DELETE FROM books WHERE id={$book['id']};");

    //deleting image
    foreach (extensions as $extension) {
        if(file_exists(IMG_PATH . $book['id'] . '.' . $extension)) {
            unlink(IMG_PATH . $book['id'] . '.' . $extension);
        }
    }
}
