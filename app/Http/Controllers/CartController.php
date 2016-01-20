<?php
namespace App\Http\Controllers;
use View;
use App\Models\Item;
use App\Models\ItemCat;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect, Input, Auth, Log;
use Session;
use Cart;

//购物车
class CartController extends Controller{
    
    public function index(){
        return view('cart.index');
    }
    
    //创建购物车
    function create($itemId){
      
        
        
    }
    
    //保存创建，下一步订单
    function save(){
        
    }
    
    //添加购物车
    public function add($itemId){
     //   Cart::add(455, 'Sample Item', 100.99, 2, array());
  

        /* 取得商品信息 */
        $item  = Item::where('id','=',$itemId)->first();
     //   var_dump($item);exit;
        /* 初始化要插入购物车的基本件数据 */
        $parent = array(
            'user_id'       => Auth::id(),
            'goods_id'      => $itemId,
            'sku'    => $item['sku'],
            'item_name'    => addslashes($item['name']),
            'price'  => $item['price'],
          //  'item_attr'    => addslashes($item['item_attr']),
         //   'item_attr_id' => $item_attr_id,
        );
        
        Cart::add($itemId,addslashes($item['name']),$item['price'],'1',array());
       
       return redirect()->route('cart.index');
    }
    
    //清空购物车
    public function clear(){
        Cart::where('session_id','=',SESS_ID)->delete();
    }
    
    /**
     * 生成订单
     */
    public function createOrder(){
        var_dump('createOrder');
    }
    
    /**
     * 确认订单
     */
    public function checkout(){
        return view('cart.checkout');
    }
    
}