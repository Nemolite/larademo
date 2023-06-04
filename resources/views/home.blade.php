@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Панель управления') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Администратора') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container addcat">
    <div class="row">
        <div class="col-6">
            @isset($category_all)
                <h1>Список категории</h1>
                @foreach ($category_all as $category)
                    <div class="category-main">
                        <div class="category-content">
                            <h2>{{ $category->name }}</h2>
                            <p>{{ $category->description }}</p>
                        </div>
                       <div class="category-forms">
                               <a href="{{ route('updatecategory',$category->id) }}"><button type="submit" class="btn btn-warning">Изменить</button></a>
                                <form method="post" action="{{ route('deletecategory') }}">
                                    @csrf
                                    <input type="hidden" name="delid" value="{{ $category->id }}">
                                    <button type="submit" class="btn btn-danger deletecategory">Удалить</button>
                                </form>
                       </div>
                    </div> <!-- category-main -->
                @endforeach
                    {{ $category_all->links() }}
            @endisset
                <p id="result_output"></p>

        </div> <!-- col-6-->
        <div class="col-6">
            @isset($category_all)
                <h1>Добавить категорию товара</h1>
                <form method="post" action="{{ route('addcategory') }}" id="addcategory" name="addcategory">
                    @csrf
                    <div class="form-group">
                        <label for="name">Название категории</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="body">Описание категории</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
                @isset($msg)
                    <div class="msg">
                        <p>{{ $msg }}</p>
                    </div>
                @endisset
            @endisset
        </div><!-- col-6 -->
    </div> <!-- row -->
</div><!-- class="container addcat" -->
<div class="container addproduct">
    <div class="row">
        <div class="col-6">
            @isset($product)
                @foreach ($product as $prod)
                    <div class="product-main">
                        <div class="product-content">
                            <h3>{{ $prod->name }}</h3>
                            <p>{{ __('Страна:') }} {{ $prod->country }}</p>
                            <p>{{ __('Цена:') }} {{ $prod->price }}</p>
                        </div> <!-- class="product-content" -->
                        <div class="product-forms">
                            <a href="{{ route('updateproduct',$prod->id) }}"><button type="submit" class="btn btn-warning">Изменить</button></a>
                            <form method="post" action="{{ route('deleteproduct') }}">
                                @csrf
                                <input type="hidden" name="delid" value="{{ $prod->id }}">
                                <button type="submit" class="btn btn-danger deletecategory">Удалить</button>
                            </form>
                        </div> <!-- class="product-forms" -->
                    </div><!-- class="product-main" -->
                @endforeach
                    {{ $product->links() }}
            @endisset
        </div> <!-- class="col-6" -->
        <div class="col-6">
            @isset($catprod)
                <h1>Добавить товар</h1>
                <form method="post" action="{{ route('addproduct') }}" id="addproduct" name="addproduct" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Название товара</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="name">Цена товара</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>
                    <div class="form-group">
                        <label for="name">Страна производитель товара</label>
                        <input type="text" class="form-control" id="country" name="country">
                    </div>
                    <div class="form-group">
                        <label for="name">Категория товара</label>
                        <select class="form-select" multiple aria-label="multiple select example" name="category[]">
                            @foreach ($catprod as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="body">Описание товара</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Изображение товара</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
                @if (session('status'))
                    <div class="msg">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
            @endisset
        </div><!-- class="col-6" -->
    </div><!-- class="row" -->
</div> <!-- class="container addproduct" -->
@endsection

