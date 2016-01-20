<?php
namespace App\Http\Controllers;
use View;
use App\Models\Item;
use App\Models\ItemCat;
use Input;
use Request;

class ItemController extends Controller{
    
    /**
     * 查看商品
     * 
     */
    public function index(){
        $item = Item::all();
        return view('item.index', ['item' => $item]);
    }
    
    /**
     * 查看一个产品
     */
    public function details(){
        
    }
    
    /**
     * 创建一个产品
     */
    public function create(){
        $itemCat = ItemCat::all(); 
        
        return view("item.create",['itemCat' => $itemCat]);
    }
    
    /**
     * 新商品
     */
    public function save(){
        $item = new Item;
        $item->cat_id = Input::get('cat_id');
        $item->name = Input::get('name');
        $item->sku = Input::get('sku');
        $item->price = Input::get('price');
        $destinationPath = "";
        $fileName = date('');
        if (Request::hasFile('logo'))
        {
            $file = Request::file('logo');
            Request::file('photo')->move($destinationPath, $fileName);
        }
        var_dump($file);
        exit;
        $item->save();
    }
    
    //属性筛选
    
    
}