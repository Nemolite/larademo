@extends('basa')
@section('account')

    <h1>Панель упраления </h1>
    <h2>Аккаунт пользователя: {{ $name }}</h2>
    <p>e-mail: {{ $email }}</p>

    @isset($userorder)
        <h3>Ваши заказы</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">№пп</th>
                <th scope="col">№ Заказа</th>
                <th scope="col">Стоимость заказа</th>
                <th scope="col">Заказанный товар</th>
                <th scope="col">Статус заказа</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($userorder as $order)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><p>{{ $order->id }}</p></td>
                    <td>
                        <p>
                            {{ $total[$order->id] }}
                        </p>
                    </td>
                    <td>
                        @isset( $products)
                            @foreach ($products[$order->id] as $product)
                                    <p>{{ $product->name }}</p>
                            @endforeach
                                <hr>
                        @endisset
                    </td>
                    <td><p class="order-status">Заказ выполнен</p></td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @endisset

@endsection
