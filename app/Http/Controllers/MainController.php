<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(){
        $category = Category::paginate(5);
        $product = Product::paginate(6);
        $data = [
            'category'=> $category,
            'product'=> $product,
        ];
        return view('index', $data );
    }

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
        //$product= DB::table('products')->whereIn('id', $product_ids)->paginate(6);
        $category = Category::paginate(5);

        $data = [
            'category'=> $category,
            'product'=> $product,
        ];

        return view('index', $data );
    }

    // Добавление товара в корзину
    public function cartproduct(Request $request){
        if (auth()->guest()){
            return redirect('/home');
        }

        $prodid = $request->prodid;
        $userid = Auth::id();
       // Записываем в сессию только id товара
        session()->push($userid,$prodid);
        return redirect('/');
    }

    public function showproduct(Request $request){
        $product = Product::find($request->showprodid);
        $data = [
            'product' => $product
        ];
        return view('showproduct', $data );
    }

    // Вывод выбранных товаров
    public function cart(){
        //dd(session()->all());
        //session()->flush();
        $userid = Auth::id();
        // Получаем массив id товаров
        $ids = session()->get($userid);

        // На всякий случай удалаем пусты значения
        if(!empty($ids)){
            $product_ids = array_filter($ids, function($element) {
                return !empty($element);
            });
        } else {
            $product_ids = [];
        }


        // Получаем список товаров по массиву id
        if(!empty($product_ids)){
            $products = Product::query()
                ->whereIn('id', $product_ids)
                ->get();
        } else {
            $products = [];
        }

        if (isset($products)&&(!empty($products))) {
            $total = 0;
            foreach ($products as $prod){
                if(isset($prod['price'])){
                    $total+=(int)$prod['price'];
                }
            }
        } else {
            $total = 0;
        }

        $productid = session('id');
        $data = [
            'user' => Auth::user()->name,
            'id'=>$productid,
            'userid'=>$userid,
            'sessionid'=>session()->getId(),
            'products' => !empty($products)?$products:null,
            'total'=>$total
        ];

        return view('cart',$data);
    }

    public function account(){
        $user = Auth::user();
        //$userorder = DB::table('orders')->where('user_id',$user->id)->get();
        $userorder = Order::where('user_id',$user->id)->get();

        $products =[];
        $total = 0;
        foreach ($userorder as $order){
            $products[] = $order->products;
            $total = $order->products->sum('price');
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

    // Оформление заказ
    public function orders(Request $request){
        $userid = Auth::id();
        $user = Auth::user();
        // Вычисление общей стоимости заказ
        $products = session()->get($userid);
        if (isset($products)) {
            $total = 0;
            foreach ($products as $prod){
                $total+=(int)$prod['price'];
            }
        } else {
            $total = 0;
        }

        $productid = session('id');
        $data = [
            'user' => Auth::user()->name,
            'id'=>$productid,
            'userid'=>$userid,
            'sessionid'=>session()->getId(),
            'products' => session()->get($userid),
            'total'=>$total,
            // Данные пользователя
            'name'=>$user->name,
            'email'=>$user->email
        ];

        return view('orders',$data);
    }
    // Удаление товара из закза

    public function cartproductdel(Request $request){

        $userid = Auth::id();
        $prodid = $request->prodid;
        $products = $request->session()->pull($userid);

        foreach ($products as $prod){
            if($prod==$prodid){
               // Arr::forget($products, $key);
                continue;
            }
            session()->push($userid,$prod);
        }

        //session()->push($userid,$products);
        return redirect('/cart');

    }

    // Подтверждение заказа
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

        $products = session()->get($userid);

        if (isset($products)) {
            $arridproduct = [];
            foreach ($products as $prod){
                $arridproduct[] = (int)$prod['id'];
            }
        }

        $productsid = Product::find($arridproduct);
        $order->products()->attach($productsid);
        return view('checkout');
    }

    public function onas(){
        $products = DB::table('products')->limit(5)->get();

        $data = [
            'products'=>$products
        ];
        return view('onas',$data);
    }

    public function contacts(){
        return view('contacts');
    }

}
