<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Работа с заказами
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminorders(){
        $orders = Order::all();
        $products =[];
        $total = 0;
        foreach ($orders as $order){
            $products[] = $order->products;
            $total = $order->products->sum('price');
        }

        $data =[
            'orders'=>$orders,
            'products' =>$products,
            'total'=>$total
        ];
        return view('adminorders',$data);
    }
}
