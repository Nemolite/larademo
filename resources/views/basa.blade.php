<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <title>Document</title>
</head>
<body>
<header class="header">
    <div class="header-main">
        <div class="headre-logo">
            <a href="{{ route('index') }}">
                <img src="{{ asset("images/logo.png") }}" alt="Логотип">
            </a>
        </div>
        <div class="header-menu">
            <nav>
                <ul>
                    <li><a href="{{ route('index') }}">Главная</a></li>
                    <li><a href="{{ route('cart') }}">Корзина</a></li>
                    <li><a href="{{ route('account') }}">Аккаунт</a></li>
                    <li><a href="{{ route('contacts') }}">Наши контакты</a></li>

                </ul>
            </nav>
        </div>
        <div class="header-login">
            <p><a href="{{ route('register') }}">Регистрация</a> / <a href="{{ route('home') }}">Вход</a></p>
        </div>
    </div>
</header>

    <div class="main">
        @yield('account')
        @yield('cart')
        <div class="main-sidebar">
            @yield('sidebar')
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
<footer class="footer">
    <div class="footer-main">
        <div class="footer-left">

        </div>
        <div class="footer-mid"></div>
        <div class="footer-right"></div>
    </div>
</footer>


<script src="{{ asset("js/script.js") }}"></script>
</body>
</html>
