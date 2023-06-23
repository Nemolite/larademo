<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    /**
     * Главная страница
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $category = Category::paginate(5);
        $product = Product::paginate(6);
        $data = [
            'category'=> $category,
            'product'=> $product,
        ];
        return view('index', $data );
    }

    /**
     * Отображение списка категрий
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cat($id){
        $cat = Category::find($id);
        $product_cat = $cat->products; // вернет все продукты для категории $id
        $product_ids = [];
       foreach ($product_cat as $prod){
           $product_ids[] =  $prod->id;
       }
        $product = Product::query()
            ->whereIn('id', $product_ids)
            ->paginate(6);

        $category = Category::paginate(5);

        $data = [
            'category'=> $category,
            'product'=> $product,
        ];

        return view('index', $data );
    }

    /**
     * Показать один продукт по клику Подробнее
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showproduct(Request $request){
        $product = Product::find($request->showprodid);
        $data = [
            'product' => $product
        ];
        return view('showproduct', $data );
    }

    /**
     * Добавление товара в корзину
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cartproduct(Request $request){
        if (Auth::user()){
            $product_id = $request->prodid;
            $user_id= Auth::id();

            Cart::addproduct($product_id,$user_id);

            return redirect('/');
        } else {
            return redirect('/admin');
        }
    }

    /**
     * Вывод выбранных товаров
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cart(){

        $userid = Auth::id();
        $products = Cart::getproduct($userid);
        $total = Cart::getsum($userid);

        $data = [
            'user' => Auth::user()->name,
            'userid'=>$userid,
            'sessionid'=>session()->getId(),
            'products' => !empty($products)?$products:null,
            'total'=>!empty($total)?$total:null
        ];

        return view('cart',$data);
    }

    /**
     * Оформление заказ
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orders(Request $request){

        $userid = Auth::id();
        $products = Cart::getproduct($userid);
        $total = Cart::getsum($userid);
        $user = Auth::user();

        $data = [
            'user' => Auth::user()->name,
            'userid'=>$userid,
            'sessionid'=>session()->getId(),
            'products' => !empty($products)?$products:null,
            'total'=>!empty($total)?$total:null,
            // Данные пользователя
            'name'=>$user->name,
            'email'=>$user->email
        ];

        return view('orders',$data);
    }

    /**
     * Удаление товара из корзины
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cartproductdel(Request $request){

        $product_id= $request->prodid;
        Cart::delproduct($product_id);

        return redirect('/cart');
    }

    /**
     * Подтверждение заказа
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function checkout(Request $request){
        $userid = Auth::id();
        $order = Order::create(
             [
                 'user_id' =>$userid,
                 'name'=>$request->name,
                 'email'=>$request->email,
                 'phone'=>$request->phone,
                 'address'=>$request->address,
             ]
        );

        $products = Cart::getproduct($userid);
        $total = Cart::getsum($userid);

        if (isset($products)&&(!empty($products))) {
            $arridproduct = [];
            foreach ($products as $prod){
                $arridproduct[] = (int)$prod['id'];
            }
        }


        $productsid = Product::find($arridproduct);
        $order->products()->attach($productsid);
        $data = [
           'productsid'=> $productsid,
            'total'=>$total,
            'userid'=>Auth::id()
        ];

        return view('checkout',$data);
    }

    /**
     * Акаунт пользователя
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function account(){
        $user = Auth::user();
        $userorder = Order::where('user_id',$user->id)->get(); // collection
        $products =[];
        $total = [];

        foreach ($userorder as $order){
            $products[$order->id] = $order->products;
            $total[$order->id] = $order->products->sum('price');
        }

        $data = [
            'name'=>$user->name,
            'email'=>$user->email,
            'userorder'=>$userorder,
            'total'=>$total,
            'products'=>$products,

        ];

        return view('account',$data);
    }

    /**
     * Страница О нас
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function onas(){
        $products = DB::table('products')->limit(5)->get();

        $data = [
            'products'=>$products
        ];
        return view('onas',$data);
    }

    /**
     * Страница контакты
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contacts(){
        return view('contacts');
    }
}
