@extends('layouts.default')

@section('main')
 <div class="row">
    <form action="{{ URL('orders/index')}}" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
          <div class="span6"> 订单号 <input type="text" id="orderid" name="orderid" class="form-control" > </div>
          <div class="span6"> 收货人姓名 <input type="text" id="buy_name" name="buy_name" class="form-control" > </div>
<div class="span6">  收货人电话 <input type="text" id="buy_tel" name="buy_tel" class="form-control" ></div>
<div class="span6"> </div>
<div class="span6">  订单时间 从    <input  class="span2" id="order_created_start" name="order_created_start"  value="" type="text"  id="datetimepicker"> </div>
<div class="span6">  到 <input type="text" id="order_created_end" name="order_created_end" class="span2" id="datetimepicker"></div>
          <button type="submit" class="btn btn-lg btn-success col-lg-12">查询</button>
     </form>
 </div>
    <a href="{{ URL('orders/importExcel') }}" class="btn btn-success btn-mini pull-left">导出</a>
     @if (count($orders) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
			    <th>id</th>
                <th>taopix 订单id</th>
				<th>收货人姓名</th>
				<th>收货人电话</th>
				<th>订单提交时间</th>
                <th>优惠活动</th>
                <th>实际支付金额</th>
                <th>商品总数</th>
                
                <th>订单状态</th>
                <th>物流单号</th>
                
                <th><i class="icon-cog"></i></th>
            </tr>
        </thead>
        <tbody>
        
             @foreach ($orders as $order)
              
              
              <tr>
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
@else
    <td></td>
@endif
					<td>{{ $order->shipping_code }}</td>
					
                    <td><a href="{{ URL('orders/details/'.$order->id) }}" class="btn btn-success btn-mini pull-left">详情</a></td>
                    <td><a href="{{ URL('orders/redo/'.$order->taopix_order_id) }}" class="btn btn-success btn-mini pull-left">重做</a></td>
                    <td><a href="{{ URL('orders/showEdit/'.$order->id) }}" class="btn btn-success btn-mini pull-left">备注</a></td>
                </tr>
             @endforeach
       
            
        </tbody>
    </table>
    <ul class="pagination">
    {!! $orders->render() !!}
    </ul>
    
   
      @else
                 没记录
        @endif
    
	
	<script>
  $(function(){
			//window.prettyPrint && prettyPrint();
			$('#order_created_start').datepicker({
				language: 'zh-CN'
			});
			
			$('#order_created_end').datepicker({
				language: 'zh-CN'
			});
			
	
		});
		
	
</script>
	
@endsection