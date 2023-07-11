<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class Selector
{
    /**
     * Упорядочить товары
     * @param $sort
     * @return mixed
     */
    public function switchsort($sort,$priceot,$pricedo){
        switch ($sort) {
            case 1:
                $product = Product::query()
                    ->orderBy('id', 'desc')
                    ->whereBetween('price', [$priceot, $pricedo])
                    ->paginate(6);
                break;
            case 2:
                $product = Product::query()
                    ->orderBy('id', 'asc')
                    ->whereBetween('price', [$priceot, $pricedo])
                    ->paginate(6);
                break;
            case 3:
                $product = Product::query()
                    ->orderBy('country', 'desc')
                    ->whereBetween('price', [$priceot, $pricedo])
                    ->paginate(6);
                break;
            case 4:
                $product = Product::query()
                    ->orderBy('name', 'desc')
                    ->whereBetween('price', [$priceot, $pricedo])
                    ->paginate(6);
                break;
            case 5:
                $product = Product::query()
                    ->orderBy('price', 'desc')
                    ->whereBetween('price', [$priceot, $pricedo])
                    ->paginate(6);
                break;
            default:
                $product = Product::query()
                    ->orderBy('id', 'desc')
                    ->whereBetween('price', [$priceot, $pricedo])
                    ->paginate(6);
        }
        return $product;
    }

    /**
     * Упорядочить товары в корзине
     * @param $sort
     * @param $product_ids
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
        public function switchsortcrt($sort,$product_ids){
        switch ($sort) {
            case 1:
                $product = Product::query()
                    ->whereIn('id', $product_ids)
                    ->orderBy('id', 'desc')
                    ->paginate(6);
                break;
            case 2:
                $product = Product::query()
                    ->whereIn('id', $product_ids)
                    ->orderBy('id', 'asc')
                    ->paginate(6);
                break;
            case 3:
                $product = Product::query()
                    ->whereIn('id', $product_ids)
                    ->orderBy('country', 'desc')
                    ->paginate(6);
                break;
            case 4:
                $product = Product::query()
                    ->whereIn('id', $product_ids)
                    ->orderBy('name', 'desc')
                    ->paginate(6);
                break;
            case 5:
                $product = Product::query()
                    ->whereIn('id', $product_ids)
                    ->orderBy('price', 'desc')
                    ->paginate(6);
                break;
            default:
                $product = Product::query()
                    ->whereIn('id', $product_ids)
                    ->orderBy('id', 'desc')
                    ->paginate(6);
        }
        return $product;
    }

    /**
     * Упорядочить заказы в админке
     * @param $ordersfilter
     * @return mixed
     */
    public function switchsortorders($ordersfilter){
        switch ($ordersfilter) {
            case 1:
                $orders = Order::select()
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 2:
                $orders = Order::select()
                    ->where('status','Новый')
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 3:
                $orders = Order::select()
                    ->where('status','Подтверждено')
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 4:
                $orders = Order::select()
                    ->where('status','Отменено')
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            default:
                $orders = Order::select()
                    ->orderBy('created_at', 'desc')
                    ->get();
        }
        return $orders;
    }
}
