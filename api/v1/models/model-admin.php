<?php
require $_SERVER['DOCUMENT_ROOT'] . '/api/v1/database/connect_db.php';

class Model_Admin{
    public function get_books_in_range($page_num, $books_per_page, $total_pages): array
    {
        //getting array of all books (all info, without author)
        $mysql = connect_db();
        $stmt = $mysql->prepare('SELECT * FROM books LIMIT ?, ?;');

        $limit_offset = ($total_pages-$page_num)*$books_per_page;
        $limit_offset = max($limit_offset, 0);
        $stmt->bind_param('ii', $limit_offset, $books_per_page);
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
        }
        return $contents;
    }


    /**
     * This method adds book to database
     *
     * @param $data array info about book [title, year, pages, img, authors, description]
     * @return void
     */
    public function add_book($data, $files) : void
    {
        $mysql = connect_db();

        //inserting book into books table
        $stmt = $mysql->prepare('INSERT INTO books (title, description, pages, year) VALUES (?, ?, ?, ?);');
        $stmt->bind_param('ssii', $data['title'], $data['description'], $data['pages'], $data['year']);
        $stmt->execute();
        //id of added book
        $book_id = $stmt->insert_id;

        //adding or finding author and adding book and author dependency
        foreach ($data['authors'] as $author){
            //check if the authors exist
            $stmt->prepare('SELECT id FROM authors WHERE name=?;');
            $stmt->bind_param('s', $author);
            $stmt->execute();
            $res = $stmt->get_result();

            //checking author
            $author_id = -1;
            if($res->num_rows>0){
                //if author exists - getting his id
                $author_id = $res->fetch_all(MYSQLI_ASSOC)[0]['id'];
            } else {
                //if author does not exist - adding new author
                $stmt->prepare('INSERT INTO authors (name) VALUES (?);');
                $stmt->bind_param('s', $author);
                $stmt->execute();
                $author_id = $stmt->insert_id;
            }

            //creating a dependency
            $stmt->prepare('INSERT INTO books_authors (book_id, author_id) VALUES (?, ?);');
            $stmt->bind_param('ii', $book_id, $author_id);
            $stmt->execute();
        }

        $name = $book_id . '.' . pathinfo($files['bookimage']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($files['bookimage']['tmp_name'], 'static/books-img/'.$name);
    }

    public function delete($id) :void {
        $mysql = connect_db();

        $stmt = $mysql->prepare('DELETE FROM books WHERE id = ?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $stmt = $mysql->prepare('DELETE FROM books_authors WHERE book_id = ?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    public function get_total_books(){
        $mysql = connect_db();

        $stmt = $mysql->prepare('SELECT COUNT(1) FROM books;');
        $stmt->execute();

        return $stmt->get_result()->fetch_row()[0];
    }

}
