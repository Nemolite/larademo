<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'product_id', 'price','quantity'];

    public function add($product_id){
        $product = Product::findOrFile($product_id);
        $cart = self::where(['session_id'=>session()->getId(),'product_id'=>$product->id]);
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
}
