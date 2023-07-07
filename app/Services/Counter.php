<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class Counter
{
    /**
     * Получение количество товара
     * @param $product_id
     * @return mixed
     */
   public function countproduct($product_id){
       $product = Product::find($product_id);
       return $product->quantity;
   }

    /**
     * Получение количества товара в корзине
     * @param $product_id
     * @param $user_id
     * @return int
     */
   public function countproductcart($product_id,$user_id){
       $session_id = session()->getId();

       $cartproduct = Cart::where([
           'session_id'=>$session_id,
           'product_id'=>$product_id,
           'user_id'=>$user_id
       ])->get('quantity')->first();

       if ($cartproduct!=NULL) {
           return $cartproduct->quantity;
       } else {
           return 0; // В корзине нет товара
       }
   }
}
