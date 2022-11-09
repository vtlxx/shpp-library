<?php
require $_SERVER['DOCUMENT_ROOT'] . '/api/v1/database/connect_db.php';

class Model {

    function get_info_by_id($id): array
    {
        //todo: searching book by id (getting info from database)
        $mysql = connect_db();
        $stmt = $mysql->prepare('SELECT * FROM books WHERE id = ?;');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $contents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];

//        print_r($contents);
//        echo "<br>".$contents['year'];

        return $contents;
    }

}

