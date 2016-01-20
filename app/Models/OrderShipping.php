<?php
/**
 * 
 */
namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;


class OrderShipping extends Model
{ 
    protected $table = 'order_shipping';
    
  
    protected $fillable = ['id','order_id','item_id','shipping_code','shipping_name','created_at'];
	
	
	public function getShippingCode($orderid){
		
		$data = DB::select('select * from order_shipping 

                            where order_id = ?', [$orderid]);
	    return $data;
	}
    
    
}