@extends('basa')
@section('onas')
    <div class="onas-main">
        <h1>О нас</h1>
        <h2>Новинки компании</h2>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="slider-logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset("images/logo.png") }}" alt="Логотип">
                        </a>
                    </div>

                </div>
                <div class="col-6">
                    <h2>Наш слоган</h2>
                    <h4>Быстрее. Выше. Сильнее</h4>
                </div>
            </div>
        </div>
        <!-- Слайдер-->
        <div class="slider">
            @foreach ($products as $product)
            <div>
                @isset($product->image)
                    <div class="main-content-img-carusel">
                        <img src="{{ Storage::url('images/'.$product->image) }}" alt="{{ $product->name }}">

                    </div>
                @endisset
                <h2>{{ $product->name }}</h2>
            </div>
            @endforeach

        </div>
    </div><!-- class="onas-main" -->
@endsection
