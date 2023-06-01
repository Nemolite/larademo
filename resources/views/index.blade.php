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

        <div class="container">


                <div class="row">

                    @foreach ($product as $prod)
                        <div class="col-4">
                            <h2>{{ $prod->name }}</h2>
                            <p>{{ $prod->price }}</p>
                            <p>{{ $prod->country }}</p>
                            <p>{{ $prod->description }}</p>
                            @isset($prod->image)
                                <div class="main-content-img">
                                    <img src="{{ Storage::url('images/'.$prod->image) }}" alt="{{ $prod->name }}">
                                </div>
                            @endisset
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
