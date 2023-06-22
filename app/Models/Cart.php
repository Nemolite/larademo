<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'product_id', 'price','quantity'];

    public function addproduct($product_id){
        $product = Product::findOrFail($product_id);
        $cart = self::where(['session_id'=>session()->getId(),'product_id'=>$product->id])->first();
        if ($cart){
            $cart->quantity++;
            $cart->save();
        } else {
            $cart = self::create([
                'session_id'=>session()->getId(),
                'product_id'=>$product->id,
                'quantity'=>1,
                'price'=>$product->price
            ]);
        }

        return $cart;
    }

    public function getproduct(){
        $products_session = self::where(['session_id'=>session()->getId()])->get();
        $ids =[];
        foreach ($products_session as $prod){
            $ids[] = $prod->id;
        }
        $products = Product::findOrFail($ids);

        return $products;
    }

    public function getsum(){
        // Подсчет общей стоимости заказа
        $total = self::query()
            ->sum('price');
        return $total;
    }

}
