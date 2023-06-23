<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'product_id', 'price','quantity','user_id'];

    /**
     * Добавление товаров в корзину
     * @param $product_id
     * @return mixed
     */
    public function addproduct($product_id,$user_id){

        $product = Product::findOrFail($product_id);
        $session_id = session()->getId();
        $cart = self::where([
            'session_id'=>$session_id,
            'product_id'=>$product->id,
            'user_id'=>$user_id
             ]) ->first();

        if ($cart){
            $cart->quantity++;
            $cart->save();
        } else {
            $cart = self::create([
                'session_id'=>$session_id,
                'product_id'=>$product->id,
                'user_id'=>$user_id,
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
    public function getproduct($user_id){
        $session_id = session()->getId();
        $products_session = self::where([
            'session_id'=>$session_id,
            'user_id'=>$user_id
            ])->get();

        if ($products_session){
            $ids =[];
            foreach ($products_session as $prod){
                $ids[] = $prod->product_id;
            }
            $products = Product::find($ids);
        } else {
            $products =  null;
        }
        return $products;

    }

    /**
     * Получение общей суммы заказа
     * @return int|mixed
     */
    public function getsum($user_id){
        $session_id = session()->getId();
        $price_quantity = self::select('price','quantity')
        ->where([
            'session_id'=>$session_id,
            'user_id'=>$user_id
            ])
            ->get();
       $total = 0;
       foreach ($price_quantity as $value){
           if( 1 < (int)$value->quantity){
               $total = $total + ( (int)$value->quantity * (int)$value->price );
           } elseif(1 == (int)$value->quantity) {
               $total = $total + (int)$value->price;
           }
       }

       return $total;
    }

    /**
     * Очистка корзины
     * @return mixed
     */
    public function clearcart($userid){
        $session_id = session()->getId();
        self::where([
            'session_id'=>$session_id,
            'user_id'=>$userid
        ])->delete();
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
