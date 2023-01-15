<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="book_block col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <script id="pattern" type="text/template">
                <div data-book-id="{book_id}" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                    <div class="book">
                        <a href="/book/<?php echo $contents['id'] ?>"><img src="/static/books-img/<?php echo $contents['id'] ?>.jpg" alt="{title}">
                            <div data-title="{title}" class="blockI">
                                <div data-book-title="{title}" class="title size_text">{title}</div>
                                <div data-book-author="{author}" class="author"><?php echo $contents['author'] ?></div>
                            </div>
                        </a>
                        <a href="/book/<?php echo $contents['id'] ?>">
                            <button type="button" class="details btn btn-success">Читать</button>
                        </a>
                    </div>
                </div>
            </script>
            <div id="id" book-id="{book_id}">
                <div id="bookImg" class="col-xs-12 col-sm-3 col-md-3 item" style="
    margin:;
"><img src="/static/books-img/<?php echo $contents['img-name'] ?>" alt="Responsive image" class="img-responsive">

                    <hr>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 info">
                    <div class="bookInfo col-md-12">
                        <div id="title" class="titleBook"><?php echo $contents['title']; ?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="bookLastInfo">
                            <div class="bookRow"><span class="properties">автор:</span><span id="author"><?php echo $contents['author'] ?></span></div>
                            <div class="bookRow"><span class="properties">год:</span><span id="year"><?php echo $contents['year'] ?></span></div>
                            <div class="bookRow"><span class="properties">страниц:</span><span id="pages"><?php echo $contents['pages'] ?></span></div>
                            <div class="bookRow"><span class="properties">isbn:</span><span id="isbn"></span></div>
                        </div>
                    </div>
                    <div class="btnBlock col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btnBookID btn-lg btn btn-success">Хочу читать!</button>
                    </div>
                    <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-xs hidden-sm">
                        <h4>О книге</h4>
                        <hr>
                        <p id="description"><?php echo $contents['description'] ?></p>
                    </div>
                </div>
                <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-md hidden-lg">
                    <h4>О книге</h4>
                    <hr>
                    <p class="description"><?php echo $contents['description'] ?></p>
                </div>
            </div>
            <script src="/static/book-page/js/book.js" defer=""></script>
        </div>
    </div>
    <div class="modal fade" id="order-book-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Информация<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#order-book-modal').modal('hide');">
                            <span aria-hidden="true">&times;</span>
                        </button></h4>
                </div>
                <div class="modal-body">
                    Получить книгу можете по адресу: ... <br/>
                    Контакты: +38XXXXXXXXXX, +38XXXXXXXXXX
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="$('#order-book-modal').modal('hide');">ОК</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #order-book-modal {
        opacity: 1;
        top: 40%;
        padding-top: 30px;
    }
</style>