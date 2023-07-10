@extends('basa')
@section('account')

    <h1>Панель упраления </h1>
    @if (session('delstatus'))
        <div class="alert alert-success">
            {{ session('delstatus') }}
        </div>
    @endif
    <h2>Аккаунт пользователя: {{ $name }}</h2>
    <p>e-mail: {{ $email }}</p>

    @isset($userorder)
        <h3>Ваши заказы</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">№пп</th>
                <th scope="col">№ Заказа</th>
                <th scope="col">Дата заказа</th>
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
                    <td><p>{{ $order->created_at->format('d F Y') }}</p></td>
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
                    <td>
                        <p class="order-status">{{ $order->status }}</p>
                        @if($loop->iteration==1)
                            <form method="post" action="{{ route('formdelorder') }}" class="formdelorder" name="formdelorder">
                                @csrf
                                <input type="hidden"  name="delorder" value="{{ $order->id }}">
                                <input type="submit" value="{{ __('Удалить заказ') }}">
                            </form>
                        @endif

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @endisset

@endsection
