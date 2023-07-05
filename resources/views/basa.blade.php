<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <!-- Свои стили-->
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
                    @auth
                    <li><a href="{{ route('cart') }}">Корзина</a></li>
                    <li><a href="{{ route('account') }}">Аккаунт</a></li>
                    @endauth
                    <li><a href="{{ route('onas') }}">О нас</a></li>
                    <li><a href="{{ route('contacts') }}">Наши контакты</a></li>

                </ul>
            </nav>
        </div>
        <div class="header-login">
            @guest
            <p><a href="{{ route('register') }}">{{ __('Регистрация') }}</a> / <a href="{{ route('home') }}">{{ __('Вход') }}</a></p>
            @else
                <p>Привет, {{ Auth::user()->name }}
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Выход') }}
                    </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </p>
            @endguest
        </div>
    </div>
</header>

    <div class="main">
        <div class="main-sidebar">
            @yield('sidebar')
            @yield('filter')

        </div>
        <div class="main-content">
            @yield('content')
            @yield('account')
            @yield('cart')
            @yield('orders')
            @yield('checkout')
            @yield('contacts')
            @yield('onas')
            @yield('showproduct')
        </div>
    </div>
<footer class="footer">
    <div class="footer-main">
        <div class="footer-left">
            @auth
            <a href="{{ route('home') }}">{{ __('Админка') }}</a></p>
            @endauth
        </div>
        <div class="footer-mid"></div>
        <div class="footer-right"></div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset("js/script.js") }}"></script>
</body>
</html>
