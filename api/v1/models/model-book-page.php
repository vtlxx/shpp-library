<?php
require $_SERVER['DOCUMENT_ROOT'] . '/api/v1/database/connect_db.php';

class Model {

    function get_info_by_id($id): array
    {
        $mysql = connect_db();

        //getting title, description, year, pages
        $stmt = $mysql->prepare('SELECT * FROM books WHERE id = ?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

        //getting author
        $stmt = $mysql->prepare('SELECT authors.name FROM books_authors 
            INNER JOIN authors ON books_authors.author_id = authors.id
            AND books_authors.book_id = ?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $authors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $authors_string = '';
        for($i = 0; $i < sizeof($authors); $i++){
            if($i == 0) {
                $authors_string .= $authors[$i]['name'];
            } else {
                $authors_string .= ', ' . $authors[$i]['name'];
            }
        }

        $contents['author'] = $authors_string;

//        print_r($contents);
//        echo "<br>".$contents['year'];

        return $contents;
    }

}

