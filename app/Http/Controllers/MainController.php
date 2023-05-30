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

        //$product = Product::find($product_ids)->paginate(6);
        $product= DB::table('products')->whereIn('id', $product_ids)->paginate(6);
        $category = Category::paginate(5);

        $data = [
            'category'=> $category,
            'product'=> $product,
        ];

        return view('index', $data );
    }

    public function cartproduct(Request $request){
        $id = $request->procuctid;
        $product = Product::find($id);
        $id = Auth::id();
        $datasesion = [
            'userid' =>$id,
            'id'=>$product->id,
            'price' =>$product->price,
            'description' =>$product->description,
            'image' =>$product->image,
            'country' =>$product->country,
        ];
        session($datasesion);
        return redirect('/');
    }

    public function cart(){
        //dd(session());
        $id = session('id');
        $userid = session('userid');
        return view('cart',['id'=>$id,'userid'=>$userid]);
    }


    public function account(){

        return view('account');
    }

}
