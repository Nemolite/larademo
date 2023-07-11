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
                <th scope="col">Количество товара</th>
                <th scope="col">Миниатюра</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $prod)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td><p>{{ $prod['name'] }}</p></td>
                    <td><p>{{ $prod['price'] }}</p></td>
                    <td><p>{{ $prod['country'] }}</p></td>
                    <td><p>{{ $prod['description'] }}</p></td>
                    <td><p>{{ \App\Models\Cart::where(['product_id'=>$prod['id']])->get()->first()->quantity }}</p></td>
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
    <form method="post" action="{{ route('checkout') }}">
        @csrf
        <h3>Данные для доставки:</h3>
        <div class="form-group">
        <input type="text" class="form-control" name="name" placeholder="Имя, Фамилия"
               required maxlength="255" value="{{ old('name', $name) }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email', $email) }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Номер телефона"
                   required maxlength="255" value="{{ old('phone') ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="Адрес доставки"
                   required maxlength="255" value="{{ old('address') ?? '' }}">
        </div>

        <input type="hidden"  name="sessionid" value="{{ $sessionid }}">
        <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
    </form>
@endsection
