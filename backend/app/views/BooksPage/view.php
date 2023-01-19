<?php

namespace app\views\BooksPage;

class View extends \app\views\View {
    protected string $linkPrev;
    protected string $linkNext;
    protected bool $isFirst;
    protected bool $isLast;

    public function setPagination(int $pageNum, bool $isFirst, bool $isLast) : void {
        //setting isFirst and isLast params for template (pagination button: disable or not)
        $this->isFirst = $isFirst;
        $this->isLast = $isLast;


        //transforming GET parameters from $_GET array to string for link (param1=value1&param2=value2)
        //for link to the previous page
        $link = $_GET;
        $link['page'] = $pageNum-1;
        array_walk($link, function(&$item, $key) {$item = "$key=$item";});
        $this->linkPrev = implode('&', $link);

        //for link to the next page
        $link = $_GET;
        $link['page'] = $pageNum+1;
        array_walk($link, function(&$item, $key) {$item = "$key=$item";});
        $this->linkNext = implode('&', $link);

        //if the page to which the link leads should be inaccessible - replace it with #
        $this->linkNext = $this->isLast ? '#' : '?' . $this->linkNext;
        $this->linkPrev = $this->isFirst ? '#' : '?' . $this->linkPrev;
    }

//    function display($contents, $is_first, $is_last, $page, $search, $books_per_page) {
//        $link_prev = 'http://library.local/';
//        $link_next = 'http://library.local/';
//        $link_prev .= '?page=' . $page - 1;
//        $link_next .= '?page=' . $page + 1;
//        if($search !== '') {
//            $link_prev .= '&search=' . $search;
//            $link_next .= '&search=' . $search;
//        }
//        $link_prev .= '&offset=' . $books_per_page;
//        $link_next .= '&offset=' . $books_per_page;
//
//        if($is_first) {
//            $link_prev = '#';
//        }
//        if($is_last) {
//            $link_next = '#';
//        }
//        $template = 'books-page';
//        include 'api/v1/templates/page-core.php';
//    }



}