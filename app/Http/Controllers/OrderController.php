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
        $total = [];
        foreach ($orders as $order){
            $products[$order->id] = $order->products;
            $total[$order->id] = $order->products->sum('price');
        }

        //dd($products);

        $data =[
            'orders'=>$orders,
            'products' =>$products,
            'total'=>$total
        ];
        return view('adminorders',$data);
    }

    /**
     * Изменение статуса в админке
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminordersstatus(Request $request){
        $order = Order::find($request->orderid);
        $order ->status = $request->status;
        $order->save();
        return redirect('adminorders');

    }
}
