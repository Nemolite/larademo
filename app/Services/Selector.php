<?php

namespace App\Services;

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
}
