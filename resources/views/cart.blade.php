@extends('basa')
@section('cart')
    <h1>Корзина пользователя {{ $user }} (id = {{ $userid }})</h1>

    @isset($products)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">№пп</th>
                <th scope="col">Наименование</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Страна</th>
                <th scope="col">Описание товара</th>
                <th scope="col">Миниатюра</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            @isset($products)
                @foreach ($products as $prod)
                    <tr>
                        <th scope="row">{{  $loop->iteration }}</th>
                        <td><p>{{ $prod['name'] }}</p></td>
                        <td><p>{{ $prod['price'] }}</p></td>
                        <td><p>{{ $prod['country'] }}</p></td>
                        <td><p>{{ $prod['description'] }}</p></td>
                        <td>
                            @isset($prod['image'])
                                <div class="mini-img">
                                    <img src="{{ Storage::url('images/'.$prod['image']) }}" alt="{{ $prod['name'] }}">
                                </div>
                            @endisset
                        </td>
                        <td>
                            <p>
                            <form method="post" action="{{ route('cartproductdel') }}">
                                @csrf
                                <input type="hidden"  name="prodid" value="{{ $prod['id'] }}">
                                <button type="submit" class="btn btn-danger">Удалить из корзины</button>
                            </form>
                            </p>
                        </td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
        <h4>Итого (стоимость вашего заказ): {{ $total }}</h4>
        <form method="post" action="{{ route('orders') }}">
            @csrf
            <input type="hidden"  name="sessionid" value="{{ $sessionid }}">
            <button type="submit" class="btn btn-primary">Оформить заказ</button>
        </form>
    @endisset
    @empty($products)
        <h3>Ваша корзина пуста</h3>
    @endempty
@endsection
