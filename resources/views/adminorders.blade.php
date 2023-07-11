@extends('layouts.app')
@section('adminorders')
    <div class="adminorders-main">
        <h1>Все заказы</h1>
        <h3>Фильтры</h3>
        <div class="admin-orders-filter">
            <form method="post" action="{{ route('adminordersfilter') }}" class="formordersfilter" name="formordersfilter">
                @csrf
                <input type="hidden"  name="ordersfilter" value="1">
                <input type="submit" value="{{ __('Показать все заказы') }}">
            </form>
            <form method="post" action="{{ route('adminordersfilter') }}" class="formordersfilter" name="formordersfilter">
                @csrf
                <input type="hidden"  name="ordersfilter" value="2">
                <input type="submit" value="{{ __('Показать новые заказы') }}">
            </form>
            <form method="post" action="{{ route('adminordersfilter') }}" class="formordersfilter" name="formordersfilter">
                @csrf
                <input type="hidden"  name="ordersfilter" value="3">
                <input type="submit" value="{{ __('Показать подтвержденные заказы') }}">
            </form>
            <form method="post" action="{{ route('adminordersfilter') }}" class="formordersfilter" name="formordersfilter">
                @csrf
                <input type="hidden"  name="ordersfilter" value="4">
                <input type="submit" value="{{ __('Показать отмененные заказы') }}">
            </form>
        </div>
        @isset($orders)
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">№пп</th>
                    <th scope="col">№ Заказа</th>
                    <th scope="col">Заказчик</th>
                    <th scope="col">Дата заказа</th>
                    <th scope="col">Телефон заказчика</th>
                    <th scope="col">Адрес доставки</th>
                    <th scope="col">Стоимость заказа</th>
                    <th scope="col">Заказанный товар</th>
                    <th scope="col">Статус заказа</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><p>{{ $order->id }}</p></td>
                        <td><p>{{ $order->name }}</p></td>
                        <td><p>{{ $order->created_at->format('d F Y') }}</p></td>
                        <td><p>{{ $order->phone }}</p></td>
                        <td><p>{{ $order->address }}</p></td>
                        <td><p>
                            {{ $total[$order->id] }}
                            </p>
                        </td>
                        <td>
                            @isset( $products[$order->id])
                                @foreach ($products[$order->id] as $product)
                                        <p>{{ $product->name }}</p>
                                        <hr>
                                @endforeach
                            @endisset

                        </td>
                        <td>
                            <form method="post" action="{{ route('adminordersstatus') }}" class="formstatus" name="formstatus{{ $order->id }}">
                                @csrf
                                <input type="hidden"  name="orderid" value="{{ $order->id }}">
                                <select class="form-select" name="status">
                                    <option selected><p class="order-status">{{ $order->status }}</p></option>
                                    <option value="Новый">Новый</option>
                                    <option value="Подтверждено">Подтверждено</option>
                                    <option value="Отменено">Отменено</option>
                                </select>
                            </form>
                            <p>Причина отмены: {{  }}</p>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        @endisset

    </div>
@endsection
