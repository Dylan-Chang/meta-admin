@extends('_layouts.default')

@section('main')

    <form action="{{ URL('orders/index')}}" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <label> 订单号 </label><input type="text" id="orderid" name="orderid" class="form-control" >
          <button type="submit" class="btn btn-lg btn-success col-lg-12">查询</button>
     </form>
     @if (count($orders) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>taopix 订单id</th>
                <th>证书秘钥代码</th>
                <th>客户</th>
                <th>手机号码</th>
               
                <th>订单总额</th>
                <th>订单日期</th>
                
                <th><i class="icon-cog"></i></th>
            </tr>
        </thead>
        <tbody>
        
             @foreach ($orders as $order)
              
              
              <tr>
                    <td>{{ $order->taopix_orderid }}</td>
                    <td><a href="">{{ $order->groupcode }}</a></td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                  
                    <td>{{ $order->total }}</td>
                    <td>{{ date('Y-m-d H:i:s', $order->date_created) }}</td>
                    <td><a href="{{ URL('orders/details/'.$order->id) }}" class="btn btn-success btn-mini pull-left">详情</a></td>
                    <td><a href="{{ URL('orders/shippingCode/'.$order->id) }}" class="btn btn-success btn-mini pull-left">物流单号</a></td>
                </tr>
             @endforeach
       
            
        </tbody>
    </table>
    <ul class="pagination">
    {!! $orders->render() !!}
    </ul>
    
   
        
    <a href="{{ URL('orders/importExcel') }}" class="btn btn-success btn-mini pull-left">导出</a>
      @else
                 没记录
        @endif
    
@endsection