<?php
require $_SERVER['DOCUMENT_ROOT'] . '/api/v1/database/connect_db.php';

class Model_Books {

    public function get_books($page_num, $books_per_page, $search): array
    {
        //getting array of all books (all info, without author)
        $mysql = connect_db();
        $contents = '';
        $stmt = '';
        $offset = ($page_num - 1) * $books_per_page;

        //if there is no search query
        if($search === '') {
            $stmt = $mysql->prepare('SELECT * FROM books ORDER BY views DESC LIMIT ?, ?;');
            $stmt->bind_param('ii', $offset, $books_per_page);
        }
        //if there is search query
        else {
            $stmt = $mysql->prepare("SELECT * FROM books WHERE title LIKE ? ORDER BY views DESC LIMIT ?, ?;");
            $query = '%' . $search . '%';
            $stmt->bind_param('sii', $query, $offset, $books_per_page);
        }

        $stmt->execute();
        $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        //getting authors for every book
        for ($i=0, $size = count($contents); $i < $size; ++$i) {
            //getting authors names array
            $stmt = $mysql->prepare('SELECT authors.name FROM books_authors 
            INNER JOIN authors ON books_authors.author_id = authors.id
            AND books_authors.book_id = ?;');
            $stmt->bind_param('i', $contents[$i]['id']);
            $stmt->execute();
            $authors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            //converting authors array to the string
            $authors_string = '';
            for ($j = 0; $j < sizeof($authors); $j++) {
                if ($j === 0) {
                    $authors_string .= $authors[$j]['name'];
                } else {
                    $authors_string .= ', ' . $authors[$j]['name'];
                }
            }
            //adding authors to the contents
            $contents[$i]['author'] = $authors_string;

            //adding image names
            $contents[$i]['img'] = $this->get_image_by_id($contents[$i]['id']);
        }
        return $contents;
    }


    public function get_image_by_id($id) : string{
        $img = '';
        if(file_exists('static/books-img/' . $id . '.jpg')){
            $img = $id . '.jpg';
        } elseif(file_exists('static/books-img/' . $id . '.jpeg')) {
            $img = $id . '.jpeg';
        } elseif ('static/books-img/' . $id . '.png'){
            $img = $id . '.png';
        }

        return $img;
    }

}

