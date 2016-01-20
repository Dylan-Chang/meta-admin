@extends('layouts.default')

@section('main')
<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>


<script src="{{ URL::asset('js/script.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.zh-CN.js') }}" charset="UTF-8"></script>

<link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet">

<div class="row">
    <form id="form1" action="" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="span4"> 订单号 <input type="text" id="orderid" name="orderid" value="{{ $search['orderid'] }}" class="form-control" > </div>
            <div class="span4"> 收货人姓名 <input type="text" id="buy_name" name="buy_name" value="{{ $search['buyname'] }}" class="form-control" > </div>
            <div class="span4">  收货人电话 <input type="text" id="buy_tel" name="buy_tel" value="{{ $search['buytel'] }}" class="form-control" ></div>


            <div class="span5">  订单时间 从    
                <input  class="span2" id="order_created_start" name="order_created_start"  value="{{ $search['createdStart'] }}" type="text"  id="datetimepicker" data-date-format="yyyy-mm-dd"> 
                到 <input type="text" id="order_created_end" name="order_created_end" value="{{ $search['createdEnd'] }}" class="span2" id="datetimepicker" data-date-format="yyyy-mm-dd"></div>
            <button type="submit" id="btn1" class="btn btn-lg btn-success col-lg-12">查询</button>


        </div>
        <button id="btn2" class="btn btn-success btn-mini pull-left">导出</button>
    </form>

    @if (count($orders) > 0)
    <table class="table table-striped" id="tab">
        <thead>
            <tr class="row">
                <th>id</th>
                <th>taopix 订单id</th>
                <th>收货人姓名</th>
                <th>收货人电话</th>
                <th>订单提交时间</th>
                <th>优惠活动</th>
                <th>实际支付金额</th>
                <th>商品总数</th>

                <th>订单状态</th>
                <th>物流信息</th>

                <th><i class="icon-cog"></i></th>
            </tr>
        </thead>
        <tbody class = "container">

            @foreach ($orders as $order)


            <tr class="row">
                <td>{{ $order->id }}</td>
                <td>{{ $order->taopix_order_id }}</td>
                <td>{{ $order->buy_name }}</td>
                <td>{{ $order->buy_tel }}</td>
                <td>{{ $order->order_created }}</td>
                <td>{{ $order->voucher_name }}</td>
                <td>{{ $order->pay_total }}</td>
                <td>{{ $order->item_count }}</td>
                @if ($order->status  == 11)
                <td>订单生产中</td>
                @elseif($order->status  == 12)
                <td>已发货</td>
                @endif


                <td id="code" style="vertical-align: middle;">

                    <?php
                    if ($order->shipping_code) {
                        foreach ($order->shipping_code as $value) {
                            //	var_dump($value->shipping_code);exit;
                            ?>

                            {{ $value->shipping_code }} |
                            {{ $value->created_at }} &


                            <?php
                        }
                    }
                    ?>

                </td>

                <td><a href="{{ URL('orders/details/'.$order->id) }}" target="_blank" class="btn btn-success btn-mini pull-left">详情</a></td>
                @if(Entrust::hasRole('admin'))
                <td><a href="{{ URL('orders/redo/'.$order->taopix_order_id) }}" target="_blank" class="btn btn-success btn-mini pull-left">重做</a></td>
                @endif
                <td><a href="{{ URL('orders/showEdit/'.$order->id) }}" target="_blank" class="btn btn-success btn-mini pull-left">编辑</a></td>

            </tr>
            @endforeach


        </tbody>
    </table>
    <ul class="pagination">
        <?php echo $orders->appends(['order_created_start' => $search['createdStart'], 'order_created_end' => $search['createdEnd'], 'buy_tel' => $search['buytel'], 'buy_name' => $search['buyname'], 'orderid' => $search['orderid']])->render(); ?>

    </ul>


    @else
    没记录
    @endif


    <script>
//提交判断
$(document).ready(function () {

    $('#btn1').click(function () {
        $("#form1")//选择form
                .first()//选择第一个 第二个用eq(1) 最后一个 last()
                .attr("action", "{{ URL('orders/index')}}")//更改属性
                .submit();//提交
    });

    $('#btn2').click(function () {
        $("#form1")//选择form
                .first()//选择第一个 第二个用eq(1) 最后一个 last()
                .attr("action", "{{ URL('orders/exportExcel')}}")//更改属性
                .submit();//提交
    });


});


$(function () {
//window.prettyPrint && prettyPrint();
    $('#order_created_start').datepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd'
    });

    $('#order_created_end').datepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd'
    });


});



    </script>

    @endsection