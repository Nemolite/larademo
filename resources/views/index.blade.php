@extends('basa')
@section('sidebar')
    @isset($category)
        <h1>Категории товаров</h1>
        <h2><a href="{{ route('index') }}">Все категории</a></h2>
        @foreach ($category as $cat)
            <h2><a href="{{ route('cat',$cat->id) }}">{{ $cat->name }}</a></h2>
        @endforeach
        {{ $category->links() }}
    @endisset
@endsection
@section('filter')
    <h1>Фильтры товаров</h1>
    <div class="filter">
        <form method="post" action="{{ route('index') }}" class="formfilter" name="formfilter">
            @csrf
            <div class="input-group">
                <span class="input-group-text">Введите диапозин цен</span>
                <input type="number"
                       min="{{ $min }}"
                       max="{{ $max }}"
                       step="100"
                       name ="priceot"
                       id="priceot"
                       value="{{ $min }}"
                >
                <input type="number"
                       min="{{ $min }}"
                       max="{{ $max }}"
                       step="100"
                       name ="pricedo"
                       id="pricedo"
                       value="{{ $max }}"
                >
            </div>
            <input type="submit" value="{{ __('Применить') }}">
        </form>
    </div>

@endsection
@section('content')
    @isset($product)
        <h1>Каталог товаров</h1>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h3>Сортировка товаров</h3>
        <div class="sort">
            <form method="post" action="{{ route('index') }}" class="formsort" name="formsort">
                @csrf
                <input type="hidden"  name="sort" value="1">
                <input type="submit" value="{{ __('С начало новые') }}">
            </form>
            <form method="post" action="{{ route('index') }}" class="formsort" name="formsort">
                @csrf
                <input type="hidden"  name="sort" value="2">
                <input type="submit" value="{{ __('С начало старые') }}">
            </form>
            <form method="post" action="{{ route('index') }}" class="formsort" name="formsort">
                @csrf
                <input type="hidden"  name="sort" value="3">
                <input type="submit" value="{{ __('По стране поставщика') }}">
            </form>
            <form method="post" action="{{ route('index') }}" class="formsort" name="formsort">
                @csrf
                <input type="hidden"  name="sort" value="4">
                <input type="submit" value="{{ __('По наименованию') }}">
            </form>
            <form method="post" action="{{ route('index') }}" class="formsort" name="formsort">
                @csrf
                <input type="hidden"  name="sort" value="5">
                <input type="submit" value="{{ __('По цене') }}">
            </form>
        </div>

        <div class="container">
                <div class="row">
                    @foreach ($product as $prod)
                        <div class="col-4">
                            <h2>{{ $prod->name }}</h2>
                            <p>Цена:{{ $prod->price }}</p>
                            @isset($prod->image)
                                <div class="main-content-img">
                                    <img src="{{ Storage::url('images/'.$prod->image) }}" alt="{{ $prod->name }}">
                                </div>
                            @endisset
                            <div class="btn-show-product">
                                <form method="post" action="{{ route('showproduct') }}">
                                    @csrf
                                    <input type="hidden"  name="showprodid" value="{{ $prod->id }}">
                                    <button type="submit" class="btn btn-success">Подробно</button>
                                </form>
                            </div>
                            @auth
                            <form method="post" action="{{ route('cartproduct') }}">
                                @csrf
                                <input type="hidden"  name="prodid" value="{{ $prod->id }}">
                                <button type="submit" class="btn btn-success">Добавить в корзину</button>
                            </form>
                            @endauth
                        </div>
                    @endforeach

                </div>

        </div>
            @if ($product->count()>=6 ) <!-- 6 - количество выводого товара -->
                {{ $product->links() }}
            @endif
   @endisset
@endsection
