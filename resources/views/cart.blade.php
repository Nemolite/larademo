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
            </tr>
            </thead>
            <tbody>
                @foreach ($products as $prod)
                    <tr>
                        <th scope="row"></th>
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
    @endisset
    @empty($products)
        <h3>Ваша корзина пуста</h3>
    @endempty
@endsection
