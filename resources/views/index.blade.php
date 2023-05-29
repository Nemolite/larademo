@extends('basa')
@section('sidebar')
    @isset($category)
        <h2><a href="{{ route('index') }}">Все категории</a></h2>
        @foreach ($category as $cat)
            <h2><a href="{{ route('cat',$cat->id) }}">{{ $cat->name }}</a></h2>
        @endforeach
        {{ $category->links() }}
    @endisset
@endsection
@section('content')
    @isset($product)
        @foreach ($product as $prod)
            <h2>{{ $prod->name }}</h2>
            <p>{{ $prod->price }}</p>
            <p>{{ $prod->country }}</p>
            <p>{{ $prod->description }}</p>
        @endforeach

   @endisset
@endsection
