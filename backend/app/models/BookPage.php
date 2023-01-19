<?php
namespace app\models;

class BookPage extends Model {

    public function incrementViews(int $id) : void{
        $this->executeDB('UPDATE books SET views=views+1 WHERE id=?;',
            'i', [$id]);
    }

    public function incrementClicks($id) : void {
        $this->executeDB('UPDATE books SET clicks=clicks+1 WHERE id=?;',
            'i', [$id]);
    }

}

