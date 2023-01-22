<?php

namespace app\views\AdminPage;

class View extends \app\views\View {
    private int $currentPage;
    private int $totalPages;

//    public function refresh_table($contents): void
//    {
//        $result = '<table class="table table-bordered table-striped">
//                <thead>
//                <tr>
//                    <th scope="col">#</th>
//                    <th scope="col">Название книги</th>
//                    <th scope="col">Авторы</th>
//                    <th scope="col">Год</th>
//                    <th scope="col">Действия</th>
//                    <th scope="col">Просмотров</th>
//                    <th scope="col">Кликов</th>
//                </tr>
//                </thead>';
//        $result .= '<tbody id="table-body">';
//        foreach ($contents as $item) {
//            $result .= '<tr><th scope="row">' . $item['id'] . '</th><td>' . $item['title'] . '</td><td>' .
//                $item['author'] . '</td><td>' . $item['year'] . '</td><td>' .
//                '<a href="#" onclick="deleteBook('. $item['id'] .');" class="text-danger">Удалить</a>' . '</td><td>' .
//                $item['views'] . '</td><td>'. $item['clicks'] .'</td>';
//        }
//
//        $result .= '</tbody></table><ul class="pagination justify-content-center">';
//        $result .= '<li class="page-item"><a class="page-link" href="#">&laquo;</a></li>';
//        for($i = 0; $i < $this->total_pages; $i++){
//            $result .= '<li class="page-item';
//            if(array_key_exists('page', $_GET)) {
//                if ($_GET['page'] == $i + 1) {
//                    $result .= ' active';
//                }
//            } else if (1 === $i + 1) {
//                $result .= ' active';
//            }
//            $result .= '"><a class="page-link" href="./admin?page='. $i+1 .'">' . $i+1 . '</a></li>';
//        }
//        $result .= '<li class="page-item"><a class="page-link" href="#">&raquo;</a></li></ul>';
//
//        echo $result;
//    }

    public function getTable(array $tableContent) : string {
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
        foreach ($tableContent as $item) {
            $result .= '<tr><th scope="row">' . $item['id'] . '</th><td>' . $item['title'] . '</td><td>' .
                $item['author'] . '</td><td>' . $item['year'] . '</td><td>' .
                '<a href="#" onclick="deleteBook('. $item['id'] .');" class="text-danger">Удалить</a>' . '</td><td>' .
                $item['views'] . '</td><td>'. $item['clicks'] .'</td>';
        }
        $result .= '</tbody></table>';

        return $result;
    }

    public function getPagination(int $currentPage, int $totalPages) : string {
        //setting left static
        if($currentPage > 1) {
            $leftStatic = [$currentPage-1, 1];
        }
        else {
            $leftStatic = ['disabled'];
        }
        //setting left dynamic
        $leftDynamic = [];
        $leftPoints = false;
        if($currentPage > ADMIN_PAGINATION_RANGE+2) {
            for($i = 0; $i < ADMIN_PAGINATION_RANGE; $i++) {
                $leftDynamic[$i] = $currentPage - ($i + 1);
            }
            $leftPoints = true;
        }
        else {
            for($i = 0; $i < $currentPage-2; $i++) {
                $leftDynamic[$i] = $currentPage - ($i+1);
            }
        }

        //setting right static
        if($currentPage < $totalPages) {
            $rightStatic = [$currentPage+1, $totalPages];
        }
        else {
            $rightStatic = ['disabled'];
        }
        //setting right dynamic
        $rightDynamic = [];
        $rightPoints = false;
        if($currentPage <= $totalPages - (ADMIN_PAGINATION_RANGE+2)) {
            for($i = 0; $i < ADMIN_PAGINATION_RANGE; $i++) {
                $rightDynamic[$i] = $currentPage + ($i + 1);
            }
            $rightPoints = true;
        }
        else {
            for($i = 0; $i < $totalPages-($currentPage+1); $i++) {
                $rightDynamic[$i] = $currentPage + ($i+1);
            }
        }

        $merged = array_merge($leftStatic, array_reverse($leftDynamic), [$currentPage], $rightDynamic, array_reverse($rightStatic));

        //left arrow
        $result = '<ul class="pagination justify-content-center">';
        if($merged[0] === 'disabled') {
            $result .= '<li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>';
        } else {
            $result .= '<li class="page-item"><a class="page-link" href="?page=' . $merged[0] . '">&laquo;</a></li>';
        }
        //numbers
        for($i = 1; $i < count($merged)-1; $i++) {
            if($merged[$i] === $currentPage) {
                $result .= '<li class="page-item active"><a class="page-link" href="?page=' . $merged[$i] . '">' . $merged[$i] . '</a></li>';
            }
            else if(($i === 2 && $leftPoints) || ($i === count($merged)-3 && $rightPoints)) {
                $result .= '<li class="page-item"><a class="page-link" href="?page=' . $merged[$i] . '">...</a></li>';
            }
            else {
                $result .= '<li class="page-item"><a class="page-link" href="?page=' . $merged[$i] . '">' . $merged[$i] . '</a></li>';
            }
        }
        //right arrow
        if($merged[count($merged)-1] === 'disabled') {
            $result .= '<li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li></ul>';
        } else {
            $result .= '<li class="page-item"><a class="page-link" href="?page=' . $merged[count($merged)-1] . '">&raquo;</a></li></ul>';
        }

        //pretty($result);
        return $result;
    }

    public function setPaginationSettings(int $currentPage, int $totalPages) : void
    {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
    }

    public function display($tableContent): void
    {
        $content = $this->getTable($tableContent);
        $pagination = $this->getPagination($this->currentPage, $this->totalPages);
        require APP_PATH . "/views/templates/{$this->template}/{$this->layout}.php";
    }
}
