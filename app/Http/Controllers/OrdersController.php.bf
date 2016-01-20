<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Orders;
use Excel;
use PDO;
use App\Queue;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect, Input, Auth, Log;
use Session;


class OrdersController extends Controller
{
    
    public function __construct()
    {
      //  parent::__construct();
    }
    
    
    //列表
    public function index(){

	  $Orders =  DB::table('Orders');
	  $Orders->leftJoin('order_shipping', 'Orders.id', '=', 'order_shipping.order_id');
	  $Orders->select('Orders.id','Orders.buy_tel','Orders.order_created','Orders.voucher_name','Orders.pay_total',
	      'order_shipping.shipping_code', 'Orders.buy_name','Orders.taopix_order_id','Orders.item_count','Orders.status');
       $orderid = Input::get('orderid');
       if($orderid){
		  $Orders->where('taopix_order_id',$orderid);
       }
       $buytel = Input::get('buy_tel');
       if($buytel){
		  $Orders->where('buy_tel',$buytel);
       }
	   
       $buyname = Input::get('buy_name');
       if($buyname){
		   $Orders->where('buy_name',$buyname);
        }
			  
		$createdStart = Input::get('order_created_start');
		$createdEnd = Input::get('order_created_end');
		if($createdStart && $createdEnd){
			//$where .= ' AND order_created between ' . $createdStart."'"." AND ' ".$createdEnd ."'";
			$Orders->whereBetween('order_created',[$createdStart,$createdEnd]);
		}
    //   var_dump();exit;
     $rs =	$Orders->orderBy('Orders.id','desc')->paginate(10);
	 return view('orders.index',['orders'=>$rs,'orderid'=>'aaa']);
       
       
    }
    
    /**
     * 详情
     * @param unknown $orderid
     */
    public function details($orderid){
        
         $data = DB::select('select * from orders 
                            LEFT JOIN item on orders.id = item.order_id 
                            LEFT JOIN order_shipping on orders.id = order_shipping.order_id 
                            where orders.id = ?', [$orderid]);
        return view('orders.details')->with('orders',$data[0]);
    }
    
    
    /**
     * 导出Excel
     * 所有订单数据
     */
    public function importExcel(){
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $data = DB::select('select o.id as ID , o.taopix_order_id as taopix订单id ,o.taopix_owner_code,o.taopix_group_code,o.taopix_uid as taopix用户id,o.status,
		o.buy_name as 收货人姓名,o.buy_tel as 收货人电话,o.buy_address as 收货人地址,o.buy_province as 收货人省份,o.buy_city as 收货人城市,o.buy_county as 收货人区县,
		o.buy_email as 收货人邮箱,o.buy_postcode as 收货人邮编,o.voucher_name as 优惠名称,o.voucher_code as 优惠码,o.voucher_price as 优惠价格,o.shipping_total as 物流费,
		order_shipping.shipping_code as 物流单号,o.shipping_name as 物流名称,o.item_count as 购买商品总数量,o.item_total as 商品总价格,o.total as 订单总金额,o.pay_total as 订单实际支付金额,
		o.pay_name as 支付方式名称,o.pay_code as 支付方式代码,o.pay_time as 支付时间,o.pay_order_id as 支付商户订单号,o.pay_status as 支付状态,o.order_created as 订单生产时间,
		o.created_at as 数据插入时间,o.updated_at as 数据更新时间,i.order_id as 订单id,i.taopix_order_id as taopix订单id,i.name as 商品名称,i.code as 商品代码,i.price as 商品单价,
		i.qty as 购买数量, i.created_at as 数据插入时间,i.updated_at as 数据更新时间 from orders as o LEFT JOIN item as i on o.id = i.order_id LEFT JOIN order_shipping on o.id = order_shipping.order_id');

    
          Excel::create('order'.date("YmdHis").rand(10,100), function($excel) use($data) {
            $excel->sheet('Sheetname', function($sheet) use($data) {
            $sheet->fromArray($data);
          });
          })->download('xls');
      
    }
    
    /**
     * 添加 回执物流单号
     */
    public function shippingCode($orderid){
       return view('orders.shippingCode',['orderid'=>$orderid]);
    }
    
    /**
     * 添加物流单号
     */
    public function addShippingCode(){
        $code = Input::get('code');
        $id = Input::get('orderid');
        $printid = Input::get('printid');
        $shippingName = Input::get('shippingName');
        $msg = '';
        
        if($code && $id) {
            //$data =  DB::update("update orders set shipping_code = :code where id = :id", ['code'=>$code, 'id'=>$id]);
            $itemId = DB::select("select id from item where order_id = '{$id}'");
            if($itemId){
                $itemId = $itemId[0]->id;
            }
            
            
            $data =  DB::update("insert into order_shipping(order_id,item_id,shipping_code,shipping_name,created_at) values('{$id}','{$itemId}','{$code}','{$shippingName}','".date('Y-m-d H:i:s')."')");
            $msg = "{$code}物流单号提交成功";
        } else {
        		return redirect()->route('order.barcode', ['printid' => $printid, 'err' => "错误的物流号或订单号"]);
        }
        
        return redirect()->route('order.barcode', ['printid' => $printid, 'msg' => $msg]);
    }
    
    
    
    /**
     * 扫码录入
     * 接收扫码信息
     */
    public function barcode(){
        // 指定本地打印机id
    	$printid = Input::get('printid');
        $msg = Input::get('msg', '');
        $err = Input::get('err', '');
  
        return view('orders.barcode', ['printid' => $printid, 'msg' => $msg, 'err' => $err]);
    }
    
    //扫码记录
    public function barcodeRecord($itemCount,$barcode,$printid){
        $itemId = DB::select("select id from item where taopix_order_id = '{$barcode}'");

        if($itemId){
            $itemId = $itemId[0]->id;
        }else{
            $itemId = 0;
        }
        $status = 0;//标识 1成功 0失败
        
            
            //新增扫码记录
            $rs = DB::insert("insert into code_scanner(order_id,item_id,created_at) values('{$barcode}','{$itemId}','".date('Y-m-d H:i:s')."')");
            if($rs){
                $status = 1;//标识 1成功 0失败
            }
            //已扫数量
            $count = DB::select("select count(*) as num from code_scanner where order_id = '{$barcode}'");
            //var_dump($count[0]->num);exit;
            $surplus = $itemCount - $count[0]->num; //计算剩余商品
            //  var_dump($itemCount);exit;
            header("Content-Type: text/html; charset=UTF-8");
            $msg = "  总共有{$itemCount}件商品，当前已扫了{$count[0]->num}件。需要等{$surplus}件商品都扫描过后才能打印物流单";
            //return view('orders.barcode', ['printid' => $printid, 'msg' => $msg]);
            if($surplus > 0){
                return view('notifications', ['message' => $msg ,'url' => URL('orders/barcode')]);
            }
            //多产品扫描
          //  return redirect()->route('order.barcode', ['printid' => $printid, 'msg' => $msg ]);
       
       // exit;
        return $status;
    }
    
    /**
    *  打印物流单信息
    */
    public function barcodeInfo() {
	
        $barcode = Input::get('barcode');
        $printid = Input::get('printid');
		
		$msg = Input::get('msg', '');
    	$err = Input::get('err', '');
    	$status = 1; //可打印
        //过滤前两位多余的零
        /*
      	if (preg_match('#^00#i', $barcode, $m)){
 		$barcode = substr($barcode,1);
	}*/
    	
    	$barcode = preg_replace('/^0+/','',$barcode);
        
        $data = DB::select('select * from orders
                            LEFT JOIN item on orders.id = item.order_id
                            where orders.taopix_order_id = ?', [$barcode]);
        // 如果没有查询到数据
        if(!$data) {
            return redirect()->route('order.barcode', ['printid' => $printid, 'err' => "未查找到 {$barcode} 订单信息"]);
        }
      //  var_dump($data[0]->item_count);
        //判断当产品数量大于1
        if($data[0]->item_count > 1){
          $status = 0;
		  $status =	$this->barcodeRecord($data[0]->item_count,$barcode,$printid);
			
		}
      //  exit;
        return view('orders.barcodeInfo', ['orders' => $data[0], 'printid' => $printid, 'status'=>$status]);
    }
	
	//重做
	public function redo($taopixOrderId){

	  $queue = DB::select("select * from queues where content = '{$taopixOrderId}' and status = 1 and type = 1");

	    if($queue){
	        $msg =  '已经在重做中';
	    }else{
	        $rs = DB::insert("insert into queues(type,content,status,created_at) values('1','{$taopixOrderId}',0,'".date('Y-m-d H:i:s')."')");
	        if($rs){
	            $msg = '重做提交成功';
	        }else{
	            $msg = '重做提交失败';
	        }
	    }
	   
	    
	   
	    return view('notifications', ['message' => $msg , 'url'=>URL('orders')]);
	}
	
	//编辑
	public function showEdit($orderid){
	    $remark = Input::get('remark');
	  //  $orderid = Input::get('orderid');
	    return view('orders.edit', ['orderid' => $orderid]);
	}
	
	//编辑 备注
	public function edit(){
	    $remark = Input::get('remark');
	    $orderid = Input::get('orderid');
	    $data = DB::update("update orders set remark = '".$remark."' where id = ".$orderid);
	    return redirect()->route('order.details', ['orderid' => $orderid]);
	}
    
 
}