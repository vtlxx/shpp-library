<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>my-library</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="library Sh++">

    <link rel="stylesheet" href="/static/libs/libs.min.css">
    <link rel="stylesheet" href="/static/<?=$this->template?>/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" crossorigin="anonymous"/>
    <script src="/static/libs/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="/static/libs/jquery-3.6.3.min.js"></script>

    <link rel="shortcut icon" href="/static/book-page/img/favicon.png">
</head>

<body data-gr-c-s-loaded="true" class="">

<?php include 'page-header.php'?>

<?php include "../$view/$template.php"?>

<?php include 'page-footer.php'?>

</body>

</html>