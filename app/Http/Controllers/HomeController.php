<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $rols = Auth::user()->rols;
        if ($rols){
            return view('home');
        } else {
            return redirect('account');
        }

    }

    // Вывод списка категории
    public function category(){
        $category_all = Category::paginate(5);
        $data = [

            'category_all'=>$category_all
        ];

        return view('home',$data);
    }

    // Добавление категории
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

    // Удаление категории
    public function deletecategory(Request $request){
        $id = $request->delid;
        DB::table('category_product')->where('category_id', '=', $id)->delete();
        $check = Category::find($id)->delete();
        if ($check) {
            return redirect('/category')->with('status', 'Категория удалена!');
        } else {
            return redirect('/category')->with('status', 'Что-то пошло не так!');
        }
    }

    // Изменения категории
    public function updatecategory($id){
        $category = Category::find($id);
        $data = [
            'category'=>$category
        ];
        return view('updatecategory',$data);
    }

    // Обновление категории
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
        $product = Product::paginate(5);
        $category = Category::all();
        $data = [
            'catprod'=>$category,
            'product'=>$product
        ];
        return view('home',$data);
    }

    // Добавление товаров
    public function addproduct(Request $request){
        $productform = $request->all();
        $filename    = $productform['image']->getClientOriginalName();

        $productform['image']->move(Storage::path('/public/images/'),$filename);
        //$url = Storage::url($filename);

        $product = Product::create([
            'name'  =>  $request->name,
            'price' =>  $request->price,
            'description'=> $request->description,
            'quantity'=> $request->quantity,
            'image' => $filename,
            'country'=> $request->country

        ]);

        $categories = Category::find($request->category);
        $product->categories()->attach($categories);

        $check = $product->save();
        $msg = $check ?'Товар сохранен':'Что-то пошло не так';
        return redirect('product')->with('status', $msg);
    }

    // Изменение товара
    public function updateproduct($id){
        $caterory = Category::all();
        $product = Product::find($id);
        $catprod = $product->categories; // вернет все категории для продукта $id
        $data = [
            'product'=>$product,
            'catprod'=>$catprod,
            'caterory'=>$caterory
        ];
        return view('product',$data);
    }

    // Обновление товара
    public function updateprod(Request $request){

        $product = Product::find($request->upprodid);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->country = $request->country;

        $productform = $request->all();
        if($productform['image']) {
            $filename    = $productform['image']->getClientOriginalName();
            $productform['image']->move(Storage::path('/public/images/'),$filename);
            $product->image = $filename;
        }
        $check = $product->save();
        if ($check) {
            return redirect('/product')->with('status', 'Товар Изменен!');
        } else {
            return redirect('/product')->with('status', 'Что-то пошло не так!');
        }

    }

    // Удаление товар
    public function deleteproduct(Request $request){
        $id = $request->delid;

        // Удаляем связи
        DB::table('category_product')->where('product_id', '=', $id)->delete();
        $check = Product::find($id)->delete();
        if ($check) {
            return redirect('/product')->with('status', 'Товар удален!');
        } else {
            return redirect('/product')->with('status', 'Что-то пошло не так!');
        }
    }

}
