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
    
    public function edit($id){
         $itemType = ItemType::findOrFail($id); 
       //  var_dump($itemType);exit;
         $data = ['id' => $id];
         foreach (array_keys($this->fields) as $field) {
             $data[$field] = old($field, $itemType->$field);
         }
         return view('admin.itemtype.edit',['data'=>$data]);
    }
    
     public function store($id)
    {
        
        $itemType = ItemType::findOrFail($id);

        foreach (array_keys($this->fields) as $field) {
            $itemType->$field = Input::get($field);
        }
        $itemType->save();
    
        return redirect("/admin/itemtype/index")->withSuccess("修改完成!");
    }
}
