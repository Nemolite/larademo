<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'product_id', 'price','quantity'];

    /**
     * Добавление товаров в корзину
     * @param $product_id
     * @return mixed
     */
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

    /**
     * Получение и показ товаров в корзине
     * @return mixed
     */
    public function getproduct(){
        $products_session = self::where(['session_id'=>session()->getId()])->get();
            $ids =[];
            foreach ($products_session as $prod){
                $ids[] = $prod->product_id;
            }
            $products = Product::find($ids);

        return $products;
    }

    /**
     * Получение общего суммы заказа
     * @return int|mixed
     */
    public function getsum(){
        $total = self::query()
            ->sum('price');
        return $total;
    }

    /**
     * Очистка корзины
     * @return mixed
     */
    public function clearcart(){
        return self::where(['session_id'=>session()->getId()])->delete();
    }

    /**
     * Удаление товара из корзины
     * @param $product_id
     * @return void
     */
    public function delproduct($product_id){
        $count_products = self::where(['product_id'=>$product_id])->count();

        if (1==$count_products){
            self::where(['product_id'=>$product_id])->delete();
        } elseif (1<$count_products){
            self::where(['product_id'=>$product_id])->first()->delete();
        }

    }

}
