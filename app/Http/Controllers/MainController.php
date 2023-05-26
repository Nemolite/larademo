<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $category = Category::all();

        $product = Product::all();

        $data = [
            'category'=> $category,
            'product'=> $product,
        ];

        return view('index', $data );
    }

    public function category($id){
        $cat = Category::find($id);
        $product = $cat->products; // вернет все продукты для категории $id

        $category = Category::all();

        $data = [
            'category'=> $category,
            'product'=> $product,
        ];

        return view('index', $data );
    }

    public function account(){

        return view('account');
    }
}
