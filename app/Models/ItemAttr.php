<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttr extends Model
{
    protected $table = 'item_attribute';
    
    protected $fillable = ['item_attr_id', 'item_id','attr_id','attr_value','attr_price'];
    
    public function getAttr($itemId){
        //保存属性
        $attrList = array();
        $sql = "SELECT g.*, a.attr_type
        FROM item_attr AS g
        LEFT JOIN attribute AS a
        ON a.attr_id = g.attr_id
        WHERE g.item_id = '$itemId'";
        $res = DB::select($sql);
    }
}
