<?php

class Model {

    function get_info_by_id($id): array
    {
        //todo: searching book by id (getting info from database)
        $contents = array('author' => 'Oleg', 'title' => 'Hippo Title', 'description' => 'Here is description',
            'pages' => '500', 'id' => $id, 'year' => 1995);

        return $contents;
    }
}

