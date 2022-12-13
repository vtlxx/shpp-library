<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach ($contents as $book) { ?>
            <div data-book-id="<?php echo $book['id']?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                <div class="book">
                    <a href="http://library.local/books/<?php echo $book['id']?>">
                        <img src="/static/books-img/<?php echo $book['img']?>" alt="<?php echo $book['title']?>">
                        <div data-title="<?php echo $book['title']?>" class="blockI" style="height: 46px;">
                            <div data-book-title="<?php echo $book['title']?>" class="title size_text"><?php echo $book['title']?></div>
                            <div data-book-author="<?php echo $book['author']?>" class="author"><?php echo $book['author']?></div>
                        </div>
                    </a>
                    <a href="http://library.local/books/<?php echo $book['id']?>">
                        <button type="button" class="details btn btn-success">Читать</button>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="text-center">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item active"><a class="page-link" href="http://library.local?page=1">1</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
        </div>
    </div>
</section>