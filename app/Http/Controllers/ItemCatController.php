<?php
namespace App\Http\Controllers;
use Redirect;
use View;
use Input;
use App\Models;
use App\Models\ItemCat;
use Illuminate\Database\Eloquent\Model;

class ItemCatController extends Controller{
    
    public function index(){
        $itemCat = ItemCat::all();
        
        return view('itemCat.index', ['itemCat' => $itemCat]);
    }
    
    /**
     * 创建一个产品
     */
    public function create(){
       // return Redirect::to('cat/add');
        return View::make("itemCat/add");
    }
    
    /**
     * 新商品
     */
    public function save(){
        $itemCat = new ItemCat;
        $itemCat->name = Input::get('name');
        $itemCat->sort = Input::get('sort');
        $itemCat->save();
        
    }
}