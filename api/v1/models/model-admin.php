<?php
require $_SERVER['DOCUMENT_ROOT'] . '/api/v1/database/connect_db.php';

class Model_Admin{
    function get_all_books(){
        //getting array of all books (all info, without author)
        $mysql = connect_db();
        $stmt = $mysql->prepare('SELECT * FROM books;');
        $stmt->execute();
        $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        //getting authors for every book
        for ($i=0; $i < sizeof($contents); ++$i) {
            //getting authors names array
            $stmt = $mysql->prepare('SELECT authors.name FROM books_authors 
            INNER JOIN authors ON books_authors.author_id = authors.id
            AND books_authors.book_id = ?;');
            $stmt->bind_param('i', $contents[$i]['id']);
            $stmt->execute();
            //converting authors array to the string
            $authors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $authors_string = '';
            for ($j = 0; $j < sizeof($authors); $j++) {
                if ($j == 0) {
                    $authors_string .= $authors[$j]['name'];
                } else {
                    $authors_string .= ', ' . $authors[$j]['name'];
                }
            }
            //adding authors to the contents
            $contents[$i]['author'] = $authors_string;
        }
        return $contents;
    }
}
