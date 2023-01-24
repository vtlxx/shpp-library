<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach ($content as $book) { ?>
            <div data-book-id="<?=$book['id']?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                <div class="book">
                    <a href="http://library.local/books/<?php echo $book['id']?>">
                        <img src="<?=IMG_PATH?><?=$book['imgName']?>" alt="<?=$book['title']?>">
                        <div data-title="<?=$book['title']?>" class="blockI" style="height: 46px;">
                            <div data-book-title="<?=$book['title']?>" class="title size_text"><?=$book['title']?></div>
                            <div data-book-author="<?=$book['author']?>" class="author"><?=$book['author']?></div>
                        </div>
                    </a>
                    <a href="http://library.local/books/<?=$book['id']?>">
                        <button type="button" class="details btn btn-success">Читать</button>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="text-center">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($this->isFirst) echo 'disabled'?>"><a class="page-link" href="<?=$this->linkPrev?>">&laquo;</a></li>
            <li class="page-item <?php if($this->isLast) echo 'disabled'?>"><a class="page-link" href="<?=$this->linkNext?>">&raquo;</a></li>
        </ul>
        </div>
    </div>
</section>