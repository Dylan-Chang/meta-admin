<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Attribute extends Model
{
    protected $table = 'attribute';

    protected $fillable = ['attr_name', 'sort','cat_id','status','attr_values','attr_input_type'];
    
    public function items()
    {
        return $this->belongsToMany('App\Models\item', 'item_attr');
    }
    
    public function itemType(){
        return $this->belongsTo('App\Models\ItemType');
    }
    
    public function getAttrList($cat_id, $item_id = 0)
    {
        
       $row =  DB::table($this->table)
                ->leftJoin('item_attribute','item_attribute.attr_id','=','attribute.id')
                ->where('attribute.cat_id','=',$cat_id)->get();
             //   ->orderBy('attribute.sort_order', 'attribute.attr_type', 'attribute.id', 'item_attrbute.attr_price', 'item_attrbute.item_attr_id')->get();
        
        /*
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
         
         */
    
        return $row;
    }
    


}
