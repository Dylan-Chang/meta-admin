<?php
namespace App\Http\Controllers;
use Redirect;
use View;
use Input;
use App\Models;
use App\Models\ItemCat;
use Illuminate\Database\Eloquent\Model;

class AttributeCatController extends Controller{
    
    public function index(){
        
    }
    
    //属性筛选
    public function filterAttr($cat){
        if ($cat['filter_attr'] > 0)
        {
            
        }
    }
    
    
}