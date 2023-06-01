@extends('basa')
@section('orders')
    <h1>Страница оформления заказа</h1>
    <h3>Ваши данные</h3>
        <h2>Ваше имя: {{ $name }}</h2>
        <p>Ваш e-mail: {{ $email }}</p>
    <h3>Ваш заказ</h3>
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
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $prod)
                <tr>
                    <th scope="row">{{ $loop->index }}</th>
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
                </tr>
            @endforeach
            </tbody>
        </table>
        <h4>Итого (стоимость вашего заказ): {{ $total }}</h4>

    @endisset
    <h3>Способ оплаты:</h3>
      Оплата после доставки
    <h3>Адрес доставки:</h3>
    Чувашия, г.Шумерля, ул.Некрасова, д.62
    <form method="post" action="{{ route('checkout') }}">
        @csrf
        <input type="hidden"  name="sessionid" value="{{ $sessionid }}">
        <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
    </form>
@endsection
