<?php
//require $_SERVER['DOCUMENT_ROOT'] . '/api/v1/database/connect_db.php';

class Model {

    function get_info_by_id($id)
    {
        $mysql = connect_db();

        //getting title, description, year, pages
        $stmt = $mysql->prepare('SELECT * FROM books WHERE id = ?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if(array_key_exists(0, $contents)) {
            $contents = $contents[0];
        }
        else {
            return 404;
        }


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

        if(file_exists('static/books-img/' . $contents['id'] . '.jpg')){
            $contents['img-name'] = $contents['id'] . '.jpg';
        } elseif(file_exists('static/books-img/' . $contents['id'] . '.jpeg')) {
            $contents['img-name'] = $contents['id'] . '.jpeg';
        } elseif ('static/books-img/' . $contents['id'] . '.png'){
            $contents['img-name'] = $contents['id'] . '.png';
        }

        //incrementing views value
        $stmt->prepare('UPDATE books SET views=' . $contents['views']+1 . ' WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $contents;
    }

    public function increment_click($id) : void {
        $mysql = connect_db();
        //$stmt = $mysql->prepare('UPDATE books SET clicks=(SELECT clicks FROM (SELECT * FROM books) as allbooks WHERE id=?)+1;');
        //$stmt->bind_param('i', $id);
        $stmt = $mysql->prepare('SELECT clicks FROM books WHERE id=?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $num_clicks = $stmt->get_result()->fetch_row()[0];

        $stmt->prepare('UPDATE books SET clicks=' . $num_clicks+1 . ' WHERE id=?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

