<?php

namespace app\controllers;

class BookPage extends Controller
{

    public function viewAction(): void
    {
        //GETTING CONTENT FROM MODEL
        $model = new \app\models\BookPage();
        $content = $model->getBookInfo($this->route['id'], ['id', 'title', 'description', 'pages', 'year']);
        //setting authors string (by converting an array to string)
        $content['author'] = implode(', ', array_column($model->getBookAuthors($this->route['id']), 'name'));
        //setting image name by book id (trying different extensions)
        $content['imgName'] = $this->getImgName($this->route['id']);
        //incrementing view count
        $model->incrementViews($this->route['id']);

        //DISPLAYING CONTENT
        $view = $this->initView();
        $view->display($content);
    }

    public function clickAction(): void
    {
        $model = new \app\models\BookPage();
        $model->incrementClicks($this->route['id']);
    }
}