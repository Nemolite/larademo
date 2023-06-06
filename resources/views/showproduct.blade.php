@extends('basa')
@section('showproduct')
    <div class="showproduct-main">
        <h1>Карточка товара</h1>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="showproduct-img">
                        @isset($product->image)
                            <div class="main-content-img-product">
                                <img src="{{ Storage::url('images/'.$product->image) }}" alt="{{ $product->name }}">
                            </div>
                        @endisset

                    </div> <!-- class="showproduct-img" -->
                </div>
                <div class="col-6">
                    <div class="showproduct-info">
                        <h2>{{ $product->name }}</h2>
                        <p>Цена:{{ $product->price }}</p>
                        <p>Страна производитель:{{ $product->country }}</p>
                        <p>Описание товара {{ $product->description }}</p>
                    </div> <!-- class="showproduct-info" -->
                </div>
            </div> <!-- class="row" -->
        </div> <!-- class="showproduct-main" -->
        <form method="post" action="{{ route('cartproduct') }}">
            @csrf
            <input type="hidden"  name="prodid" value="{{ $product->id }}">
            <button type="submit" class="btn btn-success">Добавить в корзину</button>
        </form>

    </div>
@endsection

