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
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-7">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название книги</th>
                    <th scope="col">Авторы</th>
                    <th scope="col">Год</th>
                    <th scope="col">Действия</th>
                    <th scope="col">Кликов</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($contents as $item){
                        echo '<tr><th scope="row">'.$item['id'].'</th><td>'. $item['title'] .'</td><td>'.
                            $item['author'].'</td><td>'. $item['year'] .'</td><td>'.
                            '<a href="#" class="text-danger">Удалить</a>'.'</td><td>'.
                            'клики'.'</td>';
                    }
                ?>
                </tbody>
            </table>
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
            </ul>
        </div>
        <div class="col-5">
            <h2 class="fw-bolder text-center">Добавление книги</h2>
            <div class="row">
                <div class="col-6">
                    <input class="form-control my-1" type="text" placeholder="Название книги">
                    <input class="form-control my-2" type="text" placeholder="Год издания">
                    <input class="form-control my-2" type="file">
                    <img src="" alt="Тут будет превью изображения :)" onerror="this.onerror=null; this.remove();" class="border border-dark mx-auto d-block" width="180">
                </div>
                <div class="col-6">
                    <textarea class="form-control my-1" rows="3" placeholder="Введите автора (если их несколько - через ;)"></textarea>
                    <textarea class="form-control my-2" rows="12" placeholder="Описание"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success fs-4 px-4 my-1">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>