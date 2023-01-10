<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
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
                </div>
            </nav>
        </header>
        <div class="h-50 w-100 d-flex align-items-center justify-content-center">
            <form class="needs-validation" id="login-form" method="post">
                <div class="row mb-4 fs-1 justify-content-center">Вход</div>
                <div class="row failed-password justify-content-center invisible" id="fail-label">Неверный логин или пароль!</div>
                <div class="row my-2">
                    <input class="form-control" id="login" type="text" placeholder="Логин" required>
                </div>
                <div class="row my-2">
                    <input class="form-control" id="password" type="password" placeholder="Пароль" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success fs-5 px-5" id="button-login">Войти</button>
                </div>
            </form>
        </div>
    </body>

</html>

<style>
    html, body {
        height: 100%
    }

    .failed-password {
        font-size: 10pt;
        color: red;
    }

    .isibility-hidden {
        /*display: none;*/
        visibility: hidden;
    }
</style>

<script>
    $("#login-form").submit(function(event) {
        //cancel opening other tab
        event.preventDefault();

        let login = $("#login").val();
        let password = $("#password").val();
        //sending request for login by basic auth
        fetch('http://library.local/admin', {
            method: 'POST',
            headers: {
                'Authorization': 'Basic ' + btoa(login + ':' + password)
            }
        }).then(response => {
            if(response.ok) {
                document.location.href = 'http://library.local/admin';
            } else {
                console.log('else');
                //$("#login").addClass('is-invalid');
                $("#password").addClass('is-invalid');
                $("#password").select();
                $("#fail-label").removeClass('invisible');
                //$("#password").val('');
            }
        });
    });
</script>
