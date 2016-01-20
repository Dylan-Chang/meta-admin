<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Models\Attribute;
use App\Models\ItemType;
use Input;
use App\Models\ItemCat;

class ItemTypeController extends Controller
{
    protected $fields = [
        'name' => '',
        'attr_group' => '',
        'status' => 0,

    ];
    
    public function index(){
        $itemType = ItemType::all();
        // var_dump($item);exit;
        return view('admin.itemtype.index', ['data' => $itemType]);
    }
    
    public function create(){
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view("admin.itemtype.create",$data);
    }
    
    public function save(){
        $item = new ItemType;
        $item->attr_group = Input::get('attr_group');
        $item->name = Input::get('name');
        $item->save();

        return redirect()->route('admin.itemtype.index');
    }
    
}
