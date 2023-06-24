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
@section('content')
    @isset($product)
        <h1>Каталог товаров</h1>
        <h3>Сортировка товаров</h3>
        <form method="post" action="{{ route('indexsort') }}" class="formsort" name="formsort">
            @csrf
            <select class="form-select" name="sort">
                <option value="1" selected><p class="order-status">{{ __('С начало новые') }}</p></option>
                <option value="2">{{ __('С начало старые') }}</option>
                <option value="3">{{ __('По стране поставщика') }}</option>
                <option value="4">{{ __('По наименованию') }}</option>
                <option value="5">{{ __('По цене') }}</option>
            </select>
        </form>
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

                            <form method="post" action="{{ route('cartproduct') }}">
                                @csrf
                                <input type="hidden"  name="prodid" value="{{ $prod->id }}">
                                <button type="submit" class="btn btn-success">Добавить в корзину</button>
                            </form>
                        </div>
                    @endforeach

                </div>

        </div>
            @if ($product->count()>=6 ) <!-- 6 - количество выводого товара -->
                {{ $product->links() }}
            @endif
   @endisset
@endsection
