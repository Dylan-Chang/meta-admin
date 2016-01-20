<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Http\Requests\CouponCreateRequest;

class CouponController extends Controller
{
    protected $fields = [
        'name' => '',
        'money' => 0,
        'send_type' => 0,
        'min_amount' => 0,
        'max_amount' => 0,
        'send_start_date' => '',
        'send_end_date' => '',
        'use_start_date' => '',
        'use_end_date' => '',
        'min_item_amount' => ''
        
    ];
    
    public function index(){
        $coupon = Coupon::all();

        return view('admin.coupon.index', ['data' => $coupon]);
    }
    
    public function create(){
    
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
    
        return view("admin.coupon.create",['data'=>$data]);
    }
    
    //发放红包
    public function sendPrint(){
        @set_time_limit(0);
        $num = UserCoupon::max('coupon_sn')->first();
        var_dump($num);exit;
        
    }
    
    public function store(CouponCreateRequest $request){
       $coupon =  Coupon::create($request->fillData());
       return redirect()->route('admin.coupon.index')->withSuccess('添加成功！');
    }
    
    /**
     * 优惠劵-发放
     */
    public function send($id){
        return view('admin.coupon.print');
    }
    
}