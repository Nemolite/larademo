<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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
        dd($request);
        $tmp = $request->all();
        dd($tmp);
        $prodid = $request->prodid;
        //dd($prodid);
        $product = Product::find($productid);
        //dd($product);
        $userid = Auth::id();
        $datasesion = [
            'userid'=>$userid,
            'id'=>$prodid,
            'price' =>$product->price,
            'description' =>$product->description,
            'image' =>$product->image,
            'country' =>$product->country,
        ];
        //session([$userid =>$datasesion]);
        session()->push($datasesion);
        return redirect('/');
    }

    public function cart(){
        //session()->flush();
        dd(session()->all());
        $products = session()->all();
        //dd($products[0]);
        //dd(session()->get('userid'));
        $userid = Auth::id();
        if (session()->get('userid')==$userid){

        }
        $userid = session('userid');


        $productid = session('id');
        $data = [
            'id'=>$productid,
            'userid'=>$userid,
            'sessionid'=>session()->getId()
        ];
        return view('cart',$data);
    }


    public function account(){

        $user = Auth::user();
        $data = [
            'name'=>$user->name,
            'email'=>$user->email
        ];

        return view('account',$data);
    }

}
