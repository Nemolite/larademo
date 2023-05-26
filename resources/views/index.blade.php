@extends('basa')
@section('sidebar')
    @isset($category)
        @foreach ($category as $cat)
            <h2>{{ $cat->name }}</h2>
        @endforeach
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
