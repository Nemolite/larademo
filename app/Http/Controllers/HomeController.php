<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function category(){
        $category_all = Category::paginate(5);
        $data = [

            'category_all'=>$category_all
        ];

        return view('home',$data);
    }

    public function addcategory(Request $request){

        if ($request->method()=='POST'){
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $chek = $category->save();
            if($chek) $msg = 'Категория добавлена';
            else $msg = 'Что-то пошло не так';
        } else {
            $msg = '';
        }

        /**
         * Вывод списка категорий
         */
        $category_all = Category::paginate(5);
         $data = [
             'msg'=>$msg,
             'category_all'=>$category_all
         ];
        return view('home',$data);
    }

    public function deletecategory(Request $request){
        $id = $request->delid;
        $check = Category::find($id)->delete();
        if ($check) {
            return response('Категория удалена');
        } else {
            return response('Что-то пошло не так');
        }
    }

    public function updatecategory($id){
        $category = Category::find($id);
        $data = [
            'category'=>$category
        ];
        return view('updatecategory',$data);
    }

    public function updatecat(Request $request){
        $category = Category::find($request->upid);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect('category');
    }
    /**
     * Работа с товаром
     */
    public function product(){
        $category = Category::all();
        $data = [
            'catprod'=>$category
        ];
        return view('home',$data);
    }

    public function addproduct(Request $request){
        //$productform = $request->all();
        $product = Product::create([
            'name'  =>  $request->name,
            'price' =>  $request->price,
            'description'=> $request->description,
            'country'=> $request->country
        ]);

        $categories = Category::find($request->category);
        $product->categories()->attach($categories);

        $check = $product->save();
        if ($check) {
            $msg = 'Товар добавлен';
        } else {
            $msg = 'Что-то пошло не так';
        }
        return redirect('product')->with('status', 'Товар сохранен');;
    }
}
