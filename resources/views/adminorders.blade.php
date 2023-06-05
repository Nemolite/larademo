@extends('layouts.app')
@section('adminorders')
    <div class="adminorders-main">
        <h1>Все заказы</h1>
        @isset($orders)
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">№пп</th>
                    <th scope="col">№ Заказа</th>
                    <th scope="col">Заказчик</th>
                    <th scope="col">Телефон заказчика</th>
                    <th scope="col">Адрес доставки</th>
                    <th scope="col">Стоимость заказа</th>
                    <th scope="col">Заказанный товар</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $loop->index+1 }}</th>
                        <td><p>{{ $order->id }}</p></td>
                        <td><p>{{ $order->name }}</p></td>
                        <td><p>{{ $order->phone }}</p></td>
                        <td><p>{{ $order->address }}</p></td>
                        <td><p>
{{ $total }}
                            </p>
                        </td>
                        <td>
                            @isset( $products)
                                @foreach ($products as $product)
                                    @foreach ($product as $prod)
                                        <p>{{ $prod->name }}</p>
                                        <p>{{ $prod->description }}</p>
                                        <p>{{ $prod->country }}</p>
                                        <hr>
                                    @endforeach

                                @endforeach
                            @endisset
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        @endisset

    </div>
@endsection
