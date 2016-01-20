<?php

/**
 * 
 */

namespace App\Models;

use DB;
use Input;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderShipping;
use App\Models\BaseModel;

class Orders extends BaseModel {

    protected $table = 'orders';
    protected $fillable = ['id', 'taopix_orderid', 'userid', 'date_created', 'date_last_modified', 'groupcode',
        'date_payment', 'userid', 'name', 'address', 'city', 'province', 'county',
        'status', 'voucher_name', 'voucher_code', 'voucher_price', 'remark', 'email'
    ];
    
    public static function status(){
      return   array('11'=>'订单生产中','12'=>'已发货');
    }

    public function getOrderslist() {
        DB::connection()->enableQueryLog();

        $Orders = DB::table('Orders');
        $Orders->leftJoin('order_shipping', 'Orders.id', '=', 'order_shipping.order_id');
        $Orders->select('Orders.id', 'Orders.buy_tel', 'Orders.order_created', 'Orders.voucher_name', 'Orders.pay_total', 'order_shipping.shipping_code', 'Orders.buy_name', 'Orders.taopix_order_id', 'Orders.item_count', 'Orders.status');

        $orderid = Input::get('orderid');
        if ($orderid) {
            $Orders->where('taopix_order_id', $orderid);
        }
        $buytel = Input::get('buy_tel');
        if ($buytel) {
            $Orders->where('buy_tel', $buytel);
        }

        $buyname = Input::get('buy_name');
        if ($buyname) {
            $Orders->where('buy_name', $buyname);
        }

        $createdStart = Input::get('order_created_start');
        $createdEnd = Input::get('order_created_end');

        if ($createdStart && $createdEnd) {
            //$where .= ' AND order_created between ' . $createdStart."'"." AND ' ".$createdEnd ."'";
            $Orders->whereBetween('order_created', [$createdStart, $createdEnd]);
        }
        //var_dump($createdStart.$createdEnd);exit;

        $orders['search']['orderid'] = $orderid;
        $orders['search']['buytel'] = $buytel;
        $orders['search']['buyname'] = $buyname;
        $orders['search']['createdStart'] = $createdStart;
        $orders['search']['createdEnd'] = $createdEnd;

        $rs = $Orders->orderBy('Orders.id', 'desc')->groupBy('taopix_order_id')->paginate(10);
        $queries = DB::getQueryLog();


        if ($rs) {

            for ($i = 0; $i < count($rs); $i++) {
                // $rs[$i]['shipping_code'] = OrderShipping::getShippingCode($rs[$i]['id']);
                //var_dump($rs[$i]->id);exit;
                $OrderShipping = new OrderShipping();
                $shippingCode = $OrderShipping->getShippingCode($rs[$i]->id);

                if ($shippingCode) {
                    $rs[$i]->shipping_code = $shippingCode;
                } else {
                    $rs[$i]->shipping_code = 0;
                }
                //var_dump($rs[$i]);
            }
        } else {
            return false;
        }


        // exit;
        $orders['data'] = $rs;
        return $orders;
    }

    public function getAll() {
        $data = DB::select('select o.id as ID , o.taopix_order_id as taopix订单id ,o.taopix_owner_code,o.taopix_group_code,o.taopix_uid as taopix用户id,o.status,
		o.buy_name as 收货人姓名,o.buy_tel as 收货人电话,o.buy_address as 收货人地址,o.buy_province as 收货人省份,o.buy_city as 收货人城市,o.buy_county as 收货人区县,
		o.buy_email as 收货人邮箱,o.buy_postcode as 收货人邮编,o.voucher_name as 优惠名称,o.voucher_code as 优惠码,o.voucher_price as 优惠价格,o.shipping_total as 物流费,
		order_shipping.shipping_code as 物流单号,o.shipping_name as 物流名称,o.item_count as 购买商品总数量,o.item_total as 商品总价格,o.total as 订单总金额,o.pay_total as 订单实际支付金额,
		o.pay_name as 支付方式名称,o.pay_code as 支付方式代码,o.pay_time as 支付时间,o.pay_order_id as 支付商户订单号,o.pay_status as 支付状态,o.order_created as 订单生产时间,
		o.created_at as 数据插入时间,o.updated_at as 数据更新时间,i.order_id as 订单id,i.taopix_order_id as taopix订单id,i.name as 商品名称,i.code as 商品代码,i.price as 商品单价,
		i.qty as 购买数量, i.created_at as 数据插入时间,i.updated_at as 数据更新时间 from orders as o LEFT JOIN item as i on o.id = i.order_id LEFT JOIN order_shipping on o.id = order_shipping.order_id');

        return $data;
    }

}
