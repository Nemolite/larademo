<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Selector;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Работа с заказами
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adminorders(){
        $selector = new Selector();
        $orders = $selector->switchsortorders($ordersfilter=0);
        $products =[];
        $total = [];
        foreach ($orders as $order){
            $products[$order->id] = $order->products;
            $total[$order->id] = $order->products->sum('price');
        }

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

    public function adminordersfilter(Request $request){
        $ordersfilter = $request->ordersfilter;
        $selector = new Selector();
        $orders = $selector->switchsortorders($ordersfilter);
        $products =[];
        $total = [];
        foreach ($orders as $order){
            $products[$order->id] = $order->products;
            $total[$order->id] = $order->products->sum('price');
        }

        $data =[
            'orders'=>$orders,
            'products' =>$products,
            'total'=>$total
        ];
        return view('adminorders',$data);
    }
}
