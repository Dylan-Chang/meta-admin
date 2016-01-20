<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Models\Attribute;
use App\Models\Item;
use Input;
use App\Models\ItemCat;
use App\Models\ItemType;
use DB;
use App\Models\Category;
use Plupload;
use Session;
use App\Models\Attribute;

class ItemController extends Controller
{
    protected $fields = [
        'name' => '',
        'sku' =>'',
        'qty' => '',
        'logo' => '',
        'price' => '',
        'desc' => '',
        'status' => 0,
        'cat_id' => '', 
        'code' => '',
        'order_id' => 0,
        'taopix_order_id' => 0,
    ];
    private $path;
    
    
    //上传logo
    public function upload(){
        
       return  Plupload::receive('file', function ($file)
        {
           
            $file->move(storage_path() . '/tmp/', $file->getClientOriginalName());

         //   $this->path = storage_path() . '/tmp/'.$file->getClientOriginalName();
            //Session::put('path', storage_path() . '/tmp/'.$file->getClientOriginalName());
           // return $path;
        });
       
      //  return view('admin.item.upload');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(){
        $item = Item::all();
       // var_dump($item);exit;
        return view('admin.item.index', ['item' => $item]);
    }
    
    /**
     * 创建一个产品
     * 第一步选择类目
     */
    public function create(){
        $category = Category::all();
        $itemType = ItemType::all();
        
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
       return view("admin.item.create",['category' => $category,'itemType'=>$itemType, 'data' => $data]);
    }
    
    /*
    public function create(){
        
    //    $itemCat = ItemCat::all();
        $this->fields['cat_id'] = Input::get('cat_id');
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
    
        return view("admin.item.create",$data);
    }
    
    public function select(){
        $category = Category::all();
        $itemType = ItemType::all();
        
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
       return view("admin.item.select",['category' => $category,'itemType'=>$itemType, 'data' => $data]);
    }*/
    
    
    
    public function details($id){
        //查看商品详情
        $item = Item::findOrFail($id);
        return view('admin.item.details',$item);
    }
    
    
    /**
     * 新商品
     */
    public function save(){
        
        
        Plupload::receive('file', function ($file)
        {
             
            $file->move(storage_path() . '/tmp/', $file->getClientOriginalName());
              $this->path = storage_path() . '/tmp/'.$file->getClientOriginalName();
            //Session::put('path', storage_path() . '/tmp/'.$file->getClientOriginalName());
        });
        
        $item = new Item;
        $item->cat_id = Input::get('cat_id');
        $item->name = Input::get('name');
        $item->sku = Input::get('sku');
        $item->logo = $this->path;
        $item->price = Input::get('price');
        $rs = $item->save();
        if($rs){
           
            /* 商品编号 */
            // $itemId = $item->id;
           //  $this->getAttr($itemId);
             
             //添加属性操作
             /*
             $sql = "INSERT INTO " .$ecs->table('goods_attr'). " (attr_id, goods_id, attr_value, attr_price)".
                 "VALUES ('$attr_id', '$goods_id', '$attr_value', '$info[attr_price]')";
             */
        }
        return redirect()->route('admin.item.index');
    }

    public function getItemType(){
    //    $ItemType = ItemType::all();
        //json $data;
        $id = Input::get('itemId');
        $type = Input::get('type');
        
        $attr_html = $this->build_attr_html($type,$id);
       echo json_encode($attr_html);
     
    }
    
 
    
    /**
     * 取得通用属性和某分类的属性，以及某商品的属性值
     * @param   int     $cat_id     分类编号
     * @param   int     $goods_id   商品编号
     * @return  array   规格与属性列表
     */
    /*
    function getAttrList($cat_id, $item_id = 0)
    {
        if (empty($cat_id))
        {
            return array();
        }
        
        $attribute = "attribute";
        $itemAttr = "item_attr";
    
        // 查询属性值及商品的属性值
        $sql = "SELECT a.attr_id, a.attr_name, a.attr_input_type, a.attr_type, a.attr_values, v.attr_value, v.attr_price ".
            "FROM " .$attribute. " AS a ".
            "LEFT JOIN " .$itemAttr. " AS v ".
            "ON v.attr_id = a.attr_id AND v.item_id = '$item_id' ".
            "WHERE a.cat_id = " . intval($cat_id) ." OR a.cat_id = 0 ".
            "ORDER BY a.sort_order, a.attr_type, a.attr_id, v.attr_price, v.item_attr_id";
    
        $row = DB::select($sql);
    
        return $row;
    }*/
    
    public function buildAttr($cat_id){
        
    }
    
    /**
     * 根据属性数组创建属性的表单
     *
     * @access  public
     * @param   int     $cat_id     分类编号
     * @param   int     $item_id   商品编号
     * @return  string
     */
   public  function build_attr_html($cat_id, $item_id = 0)
    {
        $GLOBALS['_LANG']['select_please'] = "请选择";
        $GLOBALS['_LANG']['spec_price'] = "规范价格";
        //$attr = get_attr_list($cat_id, $goods_id);
        //获取属性列表
       $attrObj = new Attribute;
        $attr = $attrObj->getAttrList($cat_id, $item_id);
      //  var_dump($attr);exit;
        $html = '<table width="100%" id="attrTable">';
        $spec = 0;
    
        foreach ($attr AS $key => $val)
        {
            $html .= "<tr><td >";
            if ($val->attr_type == 1 || $val->attr_type == 2)
            {
                $html .= ($spec != $val->attr_id) ?
                "<a href='javascript:;' onclick='addSpec(this)'>[+]</a>" :
                "<a href='javascript:;' onclick='removeSpec(this)'>[-]</a>";
                $spec = $val->attr_id;
            }
    
            $html .= $val->attr_name."</td><td><input type='hidden' name='attr_id_list[]' value='$val->attr_id' />";
    
            if ($val->attr_input_type == 0)
            {
                $html .= '<input name="attr_value_list[]" type="text" value="' .htmlspecialchars($val->attr_value). '" size="40" /> ';
            }
            elseif ($val->attr_input_type == 2)
            {
                $html .= '<textarea name="attr_value_list[]" rows="3" cols="40">' .htmlspecialchars($val->attr_value). '</textarea>';
            }
            else
            {
                $html .= '<select name="attr_value_list[]">';
                $html .= '<option value="">' .$GLOBALS['_LANG']['select_please']. '</option>';
    
                $attr_values = explode("\n", $val->attr_values);
    
                foreach ($attr_values AS $opt)
                {
                    $opt    = trim(htmlspecialchars($opt));
    
                    $html   .= ($val->attr_value != $opt) ?
                    '<option value="' . $opt . '">' . $opt . '</option>' :
                    '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
                }
                $html .= '</select> ';
            }
    
            $html .= ($val->attr_type == 1 || $val->attr_type == 2) ?
            $GLOBALS['_LANG']['spec_price'].' <input type="text" name="attr_price_list[]" value="' . $val->attr_price . '" size="5" maxlength="10" />' :
            ' <input type="hidden" name="attr_price_list[]" value="0" />';
    
            $html .= '</td></tr>';
        }
    
        $html .= '</table>';
    
        return $html;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //
        $item = Item::findOrFail($id);

        foreach (array_keys(array_except($this->fields, ['item'])) as $field) {
            $item->$field = $request->get($field);
        }
        $item->save();
    
        return redirect("/admin/item/index")->withSuccess("修改完成!");
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $item = Item::findOrFail($id); 
         $data = ['id' => $id];
         foreach (array_keys($this->fields) as $field) {
             $data[$field] = old($field, $item->$field);
         }
         return view('admin.item.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        foreach (array_keys(array_except($this->fields, ['item'])) as $field) {
            $item->$field = $request->get($field);
        }
        $item->save();
    
        return redirect("/admin/item/index")->withSuccess("修改完成!");
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Tag::findOrFail($id);
        $item->delete();
    
        return redirect('/admin/tag')
                        ->withSuccess(" '$item->name' 删除完成！");
    }
}
