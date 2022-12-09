<?php
//function display_table($contents_fun)
//{
//    foreach ($contents_fun as $item) {
//        echo '<tr><th scope="row">' . $item['id'] . '</th><td>' . $item['title'] . '</td><td>' .
//            $item['author'] . '</td><td>' . $item['year'] . '</td><td>' .
//            '<a href="#" class="text-danger">Удалить</a>' . '</td><td>' .
//            'клики' . '</td>';
//    }
//}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
<header>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
                <img src="/static/book-page/img/favicon.png" class="img-thumbnail" width="70">
                <span class="navbar-header fs-3 fw-lighter align-middle">Библиотека</span>
            </a>
            <a href="#" class="navbar-link text-danger fs-4 fw-bolder">Выход</a>
        </div>
    </nav>
</header>
<div class="container-fluid my-5" id="form">
    <div class="row">
        <div class="col-7" id="table-pagination">

                <?php
                    $this->refresh_table($contents);
                ?>
        </div>
        <form class="needs-validation col-5" id="book-form" method="post" enctype="multipart/form-data">
            <!--action="http://library.local/admin/add" onsubmit="sendRequest()" ||  action="http://library.local/admin/add" method="post"-->
                <h2 class="fw-bolder text-center">Добавление книги</h2>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control my-1" name="title" autocomplete="off" type="text" id="book-title" placeholder="Название книги" required>
                        <input class="form-control my-2" name="year" autocomplete="off" type="text" id="book-year" placeholder="Год издания" required>
                        <input class="form-control my-2" name="pages" autocomplete="off" type="text" id="book-pages" placeholder="Кол-во страниц" required>
                        <input class="form-control my-2" name="bookimage" type="file" id="book-img" onchange="displayPreview(event)" required>
                        <img src="" id="book-preview" alt="Тут будет превью изображения :)" class="border border-dark mx-auto d-block d-none" width="180">
                    </div>
                    <div class="col-6">
                        <textarea class="form-control my-1" name="authors" rows="3" id="book-authors" placeholder="Введите автора (если их несколько - через ;)" required></textarea>
                        <textarea class="form-control my-2" name="description" rows="12" id="book-description" placeholder="Описание" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success fs-4 px-4 my-1" id="button-add">Добавить</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<!-- Modals -->
<div class="modal fade" id="done-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Удачно</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#done-modal').modal('hide');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ухуу, книга добавлена!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="$('#done-modal').modal('hide');">ОК</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="fail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ошибка</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#fail-modal').modal('hide');">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Бабах, что-то пошло не так!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="$('#fail-modal').modal('hide');">ОК</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#book-form").submit(function (event) {
        event.preventDefault();

        //sending request to add the book
        /*fetch('http://library.local/admin/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: $('#book-form').serialize()
        }).then((response)=>{
            if(response.ok){
                $('#done-modal').modal('show');
                $('#book-title').val('');
                $('#book-year').val('');
                $('#book-pages').val('');
                $('#book-img').val('');
                $('#book-authors').val('');
                $('#book-description').val('');
                let book_preview = document.getElementById('book-preview')
                book_preview.classList.add('d-none');
            } else {
                $('#fail-modal').modal('show');
            }
        });*/
        $.ajax({
            type: 'POST',
            url: 'http://library.local/admin/add',
            data: new FormData($(this)[0]),
            //data: $(this).serialize(),
            contentType: false,
            processData: false,
            success: function (){
                //refreshing table
                $('#done-modal').modal('show');
                $('#book-title').val('');
                $('#book-year').val('');
                $('#book-pages').val('');
                $('#book-img').val('');
                $('#book-authors').val('');
                $('#book-description').val('');
                let book_preview = document.getElementById('book-preview')
                book_preview.classList.add('d-none');
                setTimeout(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'http://library.local/admin/refresh',
                        data: "",
                        cache: false,
                        success: function (data) {
                            $('#table-pagination').html(data);
                        }
                    });
                    return false
                }, 100);
            }
        });
    });
    function sendRequest(){
        // let book_info = {
        //     'title': $('#book-title').val(),
        //     'year': $('#book-year').val(),
        //     'pages': $('#book-pages').val(),
        //     'img': $('#book-img').val(),
        //     'authors': $('#book-authors').val(),
        //     'description': $('#book-description').val()
        // };
        // console.log(book_info);
        // fetch('http://library.local/admin/add', {
        //     method: 'POST',
        //     headers: {
        //         // 'Content-Type': 'multipart/form-data;charset=utf-8'
        //         'Content-Type': 'undefined'
        //     },
        //     body: JSON.stringify(book_info)
        // }).then((response)=>{
        //     if(response.ok) {
        //         $('#done-modal').modal('show');
        //         $('#book-title').val('');
        //         $('#book-year').val('');
        //         $('#book-pages').val('');
        //         $('#book-img').val('');
        //         $('#book-authors').val('');
        //         $('#book-description').val('');
        //         let book_preview = document.getElementById('book-preview')
        //         book_preview.classList.add('d-none');
        //     } else {
        //         $('#fail-modal').modal('show');
        //     }
        // });
        setTimeout(function () {
            $('#done-modal').modal('show');
            $('#book-title').val('');
            $('#book-year').val('');
            $('#book-pages').val('');
            $('#book-img').val('');
            $('#book-authors').val('');
            $('#book-description').val('');
            let book_preview = document.getElementById('book-preview')
            book_preview.classList.add('d-none');
            setTimeout(function () {
                $.ajax({
                    type: 'POST',
                    url: 'http://library.local/admin/refresh',
                    data: "",
                    cache: false,
                    success: function (data) {
                        $('#table-pagination').html(data);
                    }
                });
                return false
            }, 100);
        }, 500);
    }

    function deleteBook(id) {
        fetch('http://library.local/admin/delete?id='+id, {
            method: 'GET'
        }).then((response)=>{
            if(response.ok) {
                setTimeout(function (){
                    $.ajax({
                        type: 'POST',
                        url: 'http://library.local/admin/refresh',
                        data: "",
                        cache: false,
                        success: function (data){
                            $('#table-pagination').html(data);
                        }
                    }); return false
                }, 100);
            }
        });
    }

    function displayPreview(event){
        let book_preview = document.getElementById('book-preview');

        book_preview.src=URL.createObjectURL(event.target.files[0]);
        book_preview.classList.remove('d-none');
    }
</script>
</body>
</html>