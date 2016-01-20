<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use DB;
use App\Models\Orders;
use App\Models\OrderShipping;
use Excel;
use PDO;
use App\Queue;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect,
    Input,
    Auth,
    Log;
use Session;

class OrdersController extends Controller {

    public function __construct() {
        //  parent::__construct();
    }

    public function getImgList($taopix_order_id) {
        //http://source.artup.com/taopix_production_data/decrypted_files/0151254/ARTUP301220151232001468_001_thumb.jpg
        //	D:\TAOPIX Production Data\Decrypted Files
        // $content = file_get_contents('http://source.artup.com/server.php?path=taopix_production_data/decrypted_files/'.$taopix_order_id);
        $content = @file_get_contents('http://source.artup.com/server.php?path=' . $taopix_order_id);
        return json_decode($content);
    }

    //列表
    public function index() {
        //$Orders = new Orders;
        //$order = $Orders->getOrderslist();

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

        //  $createdEnd = date('Y-m-d',strtotime('+1 day',  strtotime(Input::get('order_created_end'))));
        // var_dump($createdEnd);exit;
        if ($createdStart && $createdEnd) {
            //$where .= ' AND order_created between ' . $createdStart."'"." AND ' ".$createdEnd ."'";
            //  $createdEnd = date('Y-m-d',strtotime('+1 day',  strtotime($createdEnd)));
            // $Orders->whereBetween('order_created', [$createdStart, $createdEnd]);
            $Orders->whereBetween('order_created', [$createdStart, date('Y-m-d', strtotime('+1 day', strtotime($createdEnd)))]);
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

        return view('orders.index', ['orders' => $orders['data'], 'orderid' => 'aaa', 'search' => $orders['search']]);
    }

    /**
     * 详情
     * @param unknown $orderid
     */
    public function details($orderid) {

        $data = DB::select('select * from orders 
                            LEFT JOIN item on orders.id = item.order_id 
                            LEFT JOIN order_shipping on orders.id = order_shipping.order_id 
                            where orders.id = ?', [$orderid]);
        // return view('orders.details')->with('orders',$data[0]);

        $taopix_order_id = '0' . $data[0]->taopix_order_id;
        $imglist = $this->getImgList($taopix_order_id);
        array_unshift($imglist, array_pop($imglist)); //将最后一张图片 移到第一张
        return view('orders.details', ['orders' => $data[0], 'imglist' => $imglist, 'imgroot' => 'http://source.artup.com/Decrypted%20Files/' . $taopix_order_id . '/']);
    }

    /**
     * 导出Excel
     * 所有订单数据
     */
    public function exportExcelAll() {
        DB::setFetchMode(PDO::FETCH_ASSOC);

        $Orders = new Orders;
        $data = $Orders->getAll();


        Excel::create('order' . date("YmdHis") . rand(10, 100), function($excel) use($data) {
            $excel->sheet('Sheetname', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

    public function object_array($array) {
        if (is_object($array)) {
            $array = (array) $array;
        } if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }

    public function exportExcel() {

        $Orders = DB::table('Orders');
        $Orders->leftJoin('order_shipping', 'Orders.id', '=', 'order_shipping.order_id');
        $Orders->select('Orders.*', 'order_shipping.shipping_code', 'order_shipping.shipping_name');
        /*
          $Orders->select('Orders.id','Orders.buy_tel','Orders.order_created','Orders.voucher_name','Orders.pay_total',
          'order_shipping.shipping_code', 'Orders.buy_name as 收货人姓名','Orders.taopix_order_id as taopix订单id','Orders.item_count as 商品总数',
          'Orders.status as 状态','Orders.voucher_name as 优惠名称','Orders.voucher_code as 优惠码','Orders.voucher_price as 优惠价格'); */
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
            $Orders->whereBetween('order_created', [$createdStart, date('Y-m-d', strtotime('+1 day', strtotime($createdEnd)))]);
        }

        $data = $Orders->orderBy('Orders.id', 'desc')->groupBy('taopix_order_id')->get();

        //var_dump($data);exit;
        /*
          $queries = DB::getQueryLog();
          $last_query = end($queries);
          var_dump($queries);
          var_dump($last_query); */
        //var_dump(end($sql));


        /*
          if($rs){

          for($i=0;$i<count($rs);$i++){
          // $rs[$i]['shipping_code'] = OrderShipping::getShippingCode($rs[$i]['id']);
          //var_dump($rs[$i]->id);exit;
          $OrderShipping = new  OrderShipping();
          $shippingCode = $OrderShipping->getShippingCode($rs[$i]->id);

          if($shippingCode){
          $rs[$i]->shipping_code = $shippingCode;
          }else{
          $rs[$i]->shipping_code = 0;
          }
          //var_dump($rs[$i]);
          }
          }else{
          return false;
          } */

        if ($data) {

            for ($i = 0; $i < count($data); $i++) {


                $OrderShipping = new OrderShipping();

                $shippingCode = $OrderShipping->getShippingCode($data[$i]->id);

                if ($shippingCode) {
                    $code = '';
                    foreach ($shippingCode as $value) {
                        $code .= $value->shipping_code . '|' . $value->created_at . '&';
                    }
                    $data[$i]->shipping_code = $code;
                } else {
                    $data[$i]->shipping_code = 0;
                }
                //var_dump($rs[$i]);
            }
        } else {
            return false;
        }



        $data = $this->object_array($data);

        Excel::create('order' . date("YmdHis") . rand(10, 100), function($excel) use($data) {
            $excel->sheet('Sheetname', function($sheet) use($data) {
                $sheet->fromArray($data);
                $sheet->row(1, array('ID', 'taopix订单id', '订单提交时间', '优惠活动', '实际支付金额', '状态', '收货人姓名', '收货人电话', '收货地址', '收货人省份', '收货人城市',
                    '收货人区县', '收货人邮箱', '收货人邮编', '优惠名称', '优惠码', '优惠价格', '物流费', '物流名称', '购买商品总数量', '商品总价格', '订单总金额', '订单实际支付金额', '支付方式名称',
                    '支付方式代码', '支付时间', '支付商户订单号', '支付状态', '订单生产时间', '数据插入时间', '数据更新时间', '订单生成时间', '物流单号'));
            });
        })->download('xls');
    }

    /**
     * 添加 回执物流单号
     */
    public function shippingCode($orderid) {
        return view('orders.shippingCode', ['orderid' => $orderid]);
    }

    /**
     * 添加物流单号
     */
    public function addShippingCode() {
        $code = Input::get('code');
        $id = Input::get('orderid');
        $printid = Input::get('printid');
        $shippingName = Input::get('shippingName');
        $msg = '';

        if ($code && $id) {
            //$data =  DB::update("update orders set shipping_code = :code where id = :id", ['code'=>$code, 'id'=>$id]);
            $item = DB::select("select id from item where order_id = '{$id}' order by id desc limit 1");
            $itemId = $item[0]->id;
            $shippingName = '中通';

            //$data =  DB::update("insert into order_shipping(order_id,item_id,shipping_code,shipping_name,created_at) values('{$id}','{$itemId}','{$code}','{$shippingName}','".date('Y-m-d H:i:s')."')");
            $orderShipping = new OrderShipping;
            $orderShipping->order_id = $id;
            $orderShipping->item_id = $itemId;
            $orderShipping->shipping_code = $code;
            $orderShipping->shipping_name = $shippingName;
            //	 $orderShipping-> = $date('Y-m-d H:i:s');
            $rs = $orderShipping->save();
            if ($rs) {
                //修改状态
                $orders = Orders::find($id);
                $orders->status = 12;
                $orders->save();

                $msg = "{$code}物流单号提交成功";
            } else {
                $msg = "{$code}物流单号提交失败";
            }
        } else {
            return redirect()->route('order.barcode', ['printid' => $printid, 'err' => "错误的物流号或订单号"]);
        }

        return redirect()->route('order.barcode', ['printid' => $printid, 'msg' => $msg]);
    }

    /**
     * 扫码录入
     * 接收扫码信息
     */
    public function barcode() {
        // 指定本地打印机id
        $printid = Input::get('printid');
        $msg = Input::get('msg', '');
        $err = Input::get('err', '');


        return view('orders.barcode', ['printid' => $printid, 'msg' => $msg, 'err' => $err]);
    }

    //扫码记录
    public function barcodeRecord($itemCount, $barcode, $printid) {
        $itemId = DB::select("select id from item where taopix_order_id = '{$barcode}'");

        if ($itemId) {
            $itemId = $itemId[0]->id;
        } else {
            $itemId = 0;
        }
        $status = 0; //标识 1成功 0失败
        //新增扫码记录
        $rs = DB::insert("insert into code_scanner(order_id,item_id,created_at) values('{$barcode}','{$itemId}','" . date('Y-m-d H:i:s') . "')");
        if ($rs) {
            $status = 1; //标识 1成功 0失败
        }
        //已扫数量
        $count = DB::select("select count(*) as num from code_scanner where order_id = '{$barcode}'");
        //var_dump($count[0]->num);exit;
        $surplus = $itemCount - $count[0]->num; //计算剩余商品
        //  var_dump($itemCount);exit;
        header("Content-Type: text/html; charset=UTF-8");
        $msg = "  总共有{$itemCount}件商品，当前已扫了{$count[0]->num}件。需要等{$surplus}件商品都扫描过后才能打印物流单";
        //return view('orders.barcode', ['printid' => $printid, 'msg' => $msg]);
        if ($surplus > 0) {
            return view('notifications', ['message' => $msg, 'url' => URL('orders/barcode')]);
        }
        //多产品扫描
        //  return redirect()->route('order.barcode', ['printid' => $printid, 'msg' => $msg ]);
        // exit;
        return $status;
    }

    public function barcodeImg() {
        // 指定本地打印机id
        $printid = Input::get('printid');
        $msg = Input::get('msg', '');
        $err = Input::get('err', '');


        return view('orders.barcodeImg', ['printid' => $printid, 'msg' => $msg, 'err' => $err]);
    }

    /**
     * 打印图片
     */
    public function barcodePrintImg() {
        $barcode = Input::get('barcode');
        $printid = Input::get('printid');

        $msg = Input::get('msg', '');
        $err = Input::get('err', '');
        $status = 1; //可打印

        $barcode = preg_replace('/^0+/', '', $barcode); //去除0
        
        $data = DB::select('select * from orders
                            LEFT JOIN item on orders.id = item.order_id
                            where orders.taopix_order_id = ?', [$barcode]);
        
        // 如果没有查询到数据
        if (!$data) {
            return redirect()->route('order.barcodeImg', ['printid' => $printid, 'err' => "未查找到 {$barcode} 订单信息"]);
        }

        $code = '0' . $barcode;
        $imgroot = 'http://source.artup.com/Decrypted%20Files/' . $code . '/';
        $imglist = $this->getImgList($code);
        if ($imglist) {
            
            array_unshift($imglist, array_pop($imglist)); //将最后一张图片 移到第一张
            
        }
        
        return view('orders.barcodePrintImg', ['barcode' => $barcode,'img' => $imgroot . $imglist[0],'orders' => $data[0], 'printid' => $printid, 'status' => $status, 'imglist' => $imglist, 'imgroot' => 'http://source.artup.com/Decrypted%20Files/' . $code . '/','msg' => $msg, 'err' => $err]);
       
      //  return view('orders.barcodePrintImg', ['img' => $imgroot . $rs, 'printid' => $printid, 'barcode' => $barcode]);
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

        $barcode = preg_replace('/^0+/', '', $barcode); //去除0

        $data = DB::select('select * from orders
                            LEFT JOIN item on orders.id = item.order_id
                            where orders.taopix_order_id = ?', [$barcode]);

        // 如果没有查询到数据
        if (!$data) {
            return redirect()->route('order.barcode', ['printid' => $printid, 'err' => "未查找到 {$barcode} 订单信息"]);
        }

        //判断当产品数量大于1
        if ($data[0]->item_count > 1) {
            $status = 0;
            $status = $this->barcodeRecord($data[0]->item_count, $barcode, $printid);
        }

        $code = '0' . $barcode;
        $imglist = $this->getImgList($code);
        if ($imglist) {
            array_unshift($imglist, array_pop($imglist)); //将最后一张图片 移到第一张
        }


        return view('orders.barcodeInfo', ['orders' => $data[0], 'printid' => $printid, 'status' => $status, 'imglist' => $imglist, 'imgroot' => 'http://source.artup.com/Decrypted%20Files/' . $code . '/']);
    }

    //重做
    public function redo($taopixOrderId) {

        $queue = DB::select("select * from queues where content = '{$taopixOrderId}' and status = 1 and type = 1");

        if ($queue) {
            $msg = '已经在重做中';
        } else {
            $rs = DB::insert("insert into queues(type,content,status,created_at) values('1','{$taopixOrderId}',0,'" . date('Y-m-d H:i:s') . "')");
            if ($rs) {
                $msg = '重做提交成功';
            } else {
                $msg = '重做提交失败';
            }
        }



        return view('notifications', ['message' => $msg, 'url' => URL('orders')]);
    }

    //编辑
    public function showEdit($orderid) {
        $remark = Input::get('remark');
        //  $orderid = Input::get('orderid');
        return view('orders.edit', ['orderid' => $orderid]);
    }

    //编辑 备注
    public function edit() {
        $remark = Input::get('remark');
        $orderid = Input::get('orderid');
        $data = DB::update("update orders set remark = '" . $remark . "' where id = " . $orderid);
        return redirect()->route('order.details', ['orderid' => $orderid]);
    }

}
