<?php
/**
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Orders extends Model
{ 
    public $timestamps = false;
    protected $table = 'orders';
    
  
    protected $fillable = ['id','taopix_orderid', 'userid', 'date_created','date_last_modified','groupcode',
        'date_payment','userid','name','address','city','province','county',
        'status','voucher_name','voucher_code','voucher_price','remark','email'
    ];
	
	public function getOrderslist(){
		$Orders =  DB::table('Orders');
		$Orders->leftJoin('order_shipping', 'Orders.id', '=', 'order_shipping.order_id');
		$Orders->select('Orders.id','Orders.buy_tel','Orders.order_created','Orders.voucher_name','Orders.pay_total',
	      'order_shipping.shipping_code','order_shipping.created_at', 'Orders.buy_name','Orders.taopix_order_id','Orders.item_count','Orders.status');
		  
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
		
		 $orders['search']['orderid'] = $orderid;
		 $orders['search']['buytel'] = $buytel;
		 $orders['search']['buyname'] = $buyname;
		 $orders['search']['createdStart'] = $createdStart;
		 $orders['search']['createdEnd'] = $createdEnd;
		 
		 
		 $orders['data'] =	$Orders->orderBy('Orders.id','desc')->paginate(10);
		 return $orders;
	}
    
    
}