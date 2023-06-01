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
        $prodid = $request->prodid;
        $product = Product::find($prodid);
        $userid = Auth::id();
        $datasesion = [
            'id'=>$prodid,
            'name'=>$product->name,
            'price' =>$product->price,
            'description' =>$product->description,
            'image' =>$product->image,
            'country' =>$product->country,
        ];

        session()->push($userid,$datasesion);
        return redirect('/');
    }

    public function cart(){
        $userid = Auth::id();
        //dd(session()->get($userid));
        $productid = session('id');
        $data = [
            'user' => Auth::user()->name,
            'id'=>$productid,
            'userid'=>$userid,
            'sessionid'=>session()->getId(),
            'products' => session()->get($userid)
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
