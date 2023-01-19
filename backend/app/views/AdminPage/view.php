<?php

namespace app\views\AdminPage;

class View extends \app\views\View {
    private int $total_pages;

    public function refresh_table($contents): void
    {
        $result = '<table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название книги</th>
                    <th scope="col">Авторы</th>
                    <th scope="col">Год</th>
                    <th scope="col">Действия</th>
                    <th scope="col">Просмотров</th>
                    <th scope="col">Кликов</th>
                </tr>
                </thead>';
        $result .= '<tbody id="table-body">';
        foreach ($contents as $item) {
            $result .= '<tr><th scope="row">' . $item['id'] . '</th><td>' . $item['title'] . '</td><td>' .
                $item['author'] . '</td><td>' . $item['year'] . '</td><td>' .
                '<a href="#" onclick="deleteBook('. $item['id'] .');" class="text-danger">Удалить</a>' . '</td><td>' .
                $item['views'] . '</td><td>'. $item['clicks'] .'</td>';
        }

        $result .= '</tbody></table><ul class="pagination justify-content-center">';
        $result .= '<li class="page-item"><a class="page-link" href="#">&laquo;</a></li>';
        for($i = 0; $i < $this->total_pages; $i++){
            $result .= '<li class="page-item';
            if(array_key_exists('page', $_GET)) {
                if ($_GET['page'] == $i + 1) {
                    $result .= ' active';
                }
            } else if (1 === $i + 1) {
                $result .= ' active';
            }
            $result .= '"><a class="page-link" href="./admin?page='. $i+1 .'">' . $i+1 . '</a></li>';
        }
        $result .= '<li class="page-item"><a class="page-link" href="#">&raquo;</a></li></ul>';

        echo $result;
    }

    function set_total_pages($pages) : void
    {
        $this->total_pages = $pages;
    }
}
