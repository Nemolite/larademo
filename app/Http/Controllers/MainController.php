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

    public function add(){

        $categories = ['Первые', 'Вторые', 'Напитки', 'Десерт', 'Детские'];
        foreach($categories as $category)
        {
            Category::create([
                'name'  =>  $category,
            ]);
        }

        $product1 = Product::create([
            'name'  =>  'Коктейль',
            'price' =>  100,
            'description' => 'Безалкогольный мохито',
            'country'=>'Бельгия'
        ]);
        $categories1 = Category::find([3,4,5]); // 'Напитки', 'Десерт', 'Детские'
        $product1->categories()->attach($categories1);

        $product2 = Product::create([
            'name'  =>  'Суп-пюре',
            'price' =>  200,
            'description' => 'Суп-пюре из тыквы',
            'country'=>'Россия'
        ]);
        $categories1 = Category::find([1,2]); // 'Первые', 'Вторые'
        $product2->categories()->attach($categories1);

        $product3 = Product::create([
            'name'  =>  'Плов',
            'price' =>  150,
            'description' => 'Мясной плов',
            'country'=>'Узбекистан'
        ]);
        $categories3 = Category::find([2]); // 'Вторые'
        $product3->categories()->attach($categories3);

        return view('index');
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
