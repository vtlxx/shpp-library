<?php
namespace app\models;

class AdminPage extends Model{

    /**
     * This method adds book to database
     *
     * @param $data array info about book [title, year, pages, authors, description]
     * @param $files array _FILES array that contains book image ['bookimage']
     * @return void
     */
    public function addBook(array $data, $files) : void
    {
        //inserting book into books table
        $mysqli = $this->getMysqli();
        $stmt = $mysqli->prepare('INSERT INTO books (title, description, pages, year) VALUES (?, ?, ?, ?);');
        $stmt->bind_param('ssii', $data['title'], $data['description'], $data['pages'], $data['year']);
        $stmt->execute();
        //id of added book
        $bookId = $stmt->insert_id;
        //adding or finding author and adding book and author dependency
        foreach ($data['authors'] as $author){
            //check if the authors exist
            $stmt->prepare('SELECT id FROM authors WHERE name=?;');
            $stmt->bind_param('s', $author);
            $stmt->execute();
            $result = $stmt->get_result();
            //checking author
            if($result->num_rows > 0) {
                //if author exists - getting his id
                $authorId = $result->fetch_all(MYSQLI_ASSOC)[0]['id'];
            }
            else {
                //if author does not exist - adding new author
                $stmt->prepare('INSERT INTO authors (name) VALUES (?);');
                $stmt->bind_param('s', $author);
                $stmt->execute();
                $authorId = $stmt->insert_id;
            }

            //creating a dependency
            $stmt->prepare('INSERT INTO books_authors (book_id, author_id) VALUES (?, ?);');
            $stmt->bind_param('ii', $bookId, $authorId);
            $stmt->execute();
        }

        //saving image
        $name = $bookId . '.' . pathinfo($files['bookimage']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($files['bookimage']['tmp_name'], IMG_PATH.$name);
    }

    public function deleteBook(int $id) : void
    {
        //finding authors, that linked with this book
        $this->executeDB('UPDATE books SET delete_date=DATE_ADD(now(), INTERVAL 1 MINUTE) WHERE id=?;',
            'i', [$id]);
    }

    public function finalDeleteBook($id) : bool
    {
        //finding authors, that linked with this book
        $authors = $this->executeDB('SELECT author_id as id FROM books_authors WHERE book_id=?;', 'i', [$id]);
        //getting only those authors, who linked only to this book
        foreach ($authors as $author)
        {
            //checking other connections for this author
            $otherBooks = $this->executeDB('SELECT COUNT(1) as count FROM books_authors WHERE author_id=? AND book_id!=?;',
                'ii', [$author['id'], $id]);
            //if this book is only link for the author - delete him
            if($otherBooks[0]['count'] === 0) {
                $this->executeDB('DELETE FROM authors WHERE id=?;', 'i', [$author['id']]);
            }
        }
        //deleting book and returning result (links will be deleted automatically)
        $mysql = $this->getMysqli();
        $stmt = $mysql->prepare('DELETE FROM books WHERE id=?;');
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
