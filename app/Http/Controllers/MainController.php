<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Counter;
use App\Services\Selector;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    /**
     * Главная страница
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request){

            $priceot = $request->priceot;
            $pricedo = $request->pricedo;

            $min = Product::query()->min('price');
            $max = Product::query()->max('price');

            $sort = $request->sort;

            if (empty($sort)) {
                $sort = session('sort');
            }

            $request->session()->put('sort', $sort);

            $selector = new Selector;
            $product =$selector->switchsort($sort,$priceot=$min,$pricedo=$max);

            $category = Category::paginate(5);
            $data = [
                'category'=> $category,
                'product'=> $product,
                'min'=>$min,
                'max'=>$max
            ];
            return view('index', $data );

    }
    /**
     * Отображение списка категрий
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cat($id){
        $min = Product::query()->min('price');
        $max = Product::query()->max('price');

        $cat = Category::find($id);
        $product_cat = $cat->products; // вернет все продукты для категории $id
        $product_ids = [];
       foreach ($product_cat as $prod){
           $product_ids[] =  $prod->id;
       }

        $sort = session('sort');
        $selector = new Selector;
        $product = $selector->switchsortcrt($sort,$product_ids);

        $category = Category::paginate(5);
        $data = [
            'category'=> $category,
            'product'=> $product,
            'min'=>$min,
            'max'=>$max
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

            $counter= new Counter();
            $countproduct = $counter->countproduct($product_id);
            $countproductcart = $counter->countproductcart($product_id,$user_id);

             if ($countproduct>$countproductcart) {
                 Cart::addproduct($product_id,$user_id);
                 return redirect('/')->with('statusyes', 'Товар добавлен!');
             }  else {
                 return redirect('/')->with('statusno', 'Нельзя добавить товар!');
             }


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
       $pass = $request->pass;
       $password = User::find(Auth::id());
          if (Hash::check($pass,$password->password)) {

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

          } else {
              return redirect()->back()->with('statusorder', 'Вы не верно ввели пароль');
          }

    }

    /**
     * Удаление товара из корзины
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cartproductdel(Request $request){
        $user_id =Auth::id();
        $product_id= $request->prodid;
        Cart::delproduct($product_id,$user_id);
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
                 'status'=>'Подтверждено',
             ]
        );

        $products = Cart::getproduct($userid);
        $total = Cart::getsum($userid);

        if (isset($products)&&(!empty($products))) {
            $arridproduct = [];
            foreach ($products as $prod){
                $arridproduct[] = (int)$prod['id'];
                $product = Product::find($prod['id']);
                $quantity = Cart::query()->where('product_id',$prod['id'] )->get()->first();
                $order->products()->attach($product, ['quantity_product' => $quantity->quantity]);
            }
        }


        $productsid = Product::find($arridproduct);
        $data = [
           'productsid'=> $productsid,
            'total'=>$total,
            'userid'=>Auth::id()
        ];

        return view('checkout',$data);
    }

    /**
     * Возможность удалить последний (новый) заказ
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formdelorder(Request $request){
        DB::table('order_product')->where('order_id',$request->delorder)->delete();
        Order::find($request->delorder)->delete();

        return redirect()->back()->with('delstatus','Ваш полседний зкакз успешно удален');
    }

    /**
     * Акаунт пользователя
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function account(){
        $user = Auth::user();
        $userorder = Order::where('user_id',$user->id)
                            ->orderBy('created_at', 'desc')
                            ->get(); // collection
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
        $products = DB::table('products')
            ->limit(5)
            ->orderBy('id', 'desc')
            ->get();

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
