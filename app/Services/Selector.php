<?php

namespace App\Services;

use App\Models\Product;

class Selector
{

    public function switchsort($sort){
        switch ($sort) {
            case 1:
                $product = Product::orderBy('id', 'desc')->paginate(6);
                break;
            case 2:
                $product = Product::orderBy('id', 'asc')->paginate(6);
                break;
            case 3:
                $product = Product::orderBy('country', 'desc')->paginate(6);
                break;
            case 4:
                $product = Product::orderBy('name', 'desc')->paginate(6);
                break;
            case 5:
                $product = Product::orderBy('price', 'desc')->paginate(6);
                break;
            default:
                $product = Product::orderBy('id', 'desc')->paginate(6);
        }
        return $product;
    }
}
