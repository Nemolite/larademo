@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container addcat">
    <div class="row">
        <div class="col-4">
            @isset($category_all)
                <h1>Список категории</h1>
                @foreach ($category_all as $category)
                    <h2>{{ $category->name }}</h2>
                    <p>{{ $category->description }}</p>
                   <div class="category-forms">
                       <a href="{{ route('updatecategory',$category->id) }}"><button type="submit" class="btn btn-warning">Изменить</button></a>
                    <form method="post" action="{{ route('deletecategory') }}">
                        @csrf
                        <input type="hidden" name="delid" value="{{ $category->id }}">
                        <button type="submit" class="btn btn-danger deletecategory">Удалить</button>
                    </form>
                   </div>
                @endforeach
                    {{ $category_all->links() }}
            @endisset
                <p id="result_output"></p>

        </div> <!-- col-4-->
        <div class="col-8">
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
        </div><!-- col-8 -->
    </div> <!-- row -->
</div>
@endsection

