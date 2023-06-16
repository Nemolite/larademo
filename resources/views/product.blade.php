@extends('layouts.app')
@section('updateproduct')
    <div class="updateproduct-main">
        <form method="post" action="{{ route('updateprod') }}" id="updateprod" name="updateprod" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="upprodid" value="{{ $product->id }}" />
                <div class="form-group">
                    <label for="name">Название товара</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                </div>
                <div class="form-group">
                    <label for="name">Цена товара</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
                </div>
                <div class="form-group">
                    <label for="name">Страна производитель товара</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ $product->country }}">
                </div>
                <div class="form-group">
                    <label for="name">Категория товара</label>
                    <p class="prod-cat">{{__('Выбранные категории:')}}
                        @foreach ($catprod as $cp)
                            {{ $cp->name }},
                        @endforeach
                    </p>
                    <select class="form-select" multiple aria-label="multiple select example" name="category[]">
                        @foreach ($caterory as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="body">Описание товара</label>
                    <textarea class="form-control" id="description" rows="3" name="description" value="{{ $product->description }}">

                    </textarea>
                </div>
                <div class="form-group">
                    <label for="quantity">Количество товара</label>
                    <input type="number" class="form-control" id="quantity" min="1" name="quantity" value="{{ $product->quantity }}">
                </div>
                <div class="form-group">
                        @isset($product->image)
                            <label for="image">Изображение товара</label>
                                <div class="main-content-img-admin-mini">
                                    <img src="{{ Storage::url('images/'.$product->image) }}" alt="{{ $product->name }}">
                                </div>
                            <input type="file" class="form-control-file" id="image" name="image" value="Изменить изображение товара">
                        @endisset
                        @empty($product->image)
                            <input type="file" class="form-control-file" id="image" name="image" value="Добавить изображение товара">
                        @endempty
                </div>
            <button type="submit" class="btn btn-primary">Изменить</button>
        </form>
    </div><!-- class="updatecategory-main" -->
@endsection
