@extends('layouts.app')
@section('updatecategory')
    <form method="post" action="{{ route('updatecat') }}" id="updatecat" name="updatecat">
        @csrf
        <input type="hidden" name="upid" value="{{ $category->id }}" />
        <div class="form-group">
            <label for="name">Название категории</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
        </div>
        <div class="form-group">
            <label for="body">Описание категории</label>
            <textarea class="form-control" id="description" rows="3" name="description" value="{{ $category->description}}"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Изменить</button>
    </form>
@endsection
