@extends('layouts.default')


@section('headjs')
<script language="javascript" src=" {{ asset('/js/LodopFuncs.js') }}"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
		<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

@stop

@section('main')

<div class="row">
 <form action="{{ route('order.barcodePrintImg', ['printid' => $printid]) }}" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="printid" value="{{ $printid }}">
          
          <p style="font-size:32px;padding-bottom:20px;">打印图片 请扫描商品条形码</p>
          <input type="text" id="barcode" name="barcode" value="" class="form-control" >
          
          <button type="submit" class="btn btn-lg btn-success col-lg-12" style="display:none;">确认</button>
          
           @if($err)
     	<div class="alert alert-danger" role="alert" style="font-size:24px;width:400px;padding:15px;">{{$err}}</div>
      @endif
      
      @if($msg)
     	<div class="alert alert-info" role="alert" style="font-size:24px;width:400px;padding:15px;">{{$msg}}</div>
      @endif
  </form>
</div>

<div class="row">
			<dl class="dl-horizontal">
				<dt>订单日期:</dt>
			  <dd>{{$orders->order_created}}</dd>
			  
			  <dt>订单号:</dt>
			  <dd>{{ $orders->taopix_order_id }}</dd>
			  
			  <dt>收货人姓名：</dt>
			  <dd>{{$orders->buy_name}}</dd>
			  
			  <dt>收货人电话：</dt>
			  <dd>{{$orders->buy_tel}}</dd>
			  
			  <dt>收货人城市：</dt>
			  <dd>{{ $orders->buy_province}}</dd>
			  
			  <dt>收货人地址：</dt>
			  <dd>{{ $orders->buy_address}}</dd>
			</dl>
</div>


<div class="row">
	<table class="table table-striped">
  		<tr>
  			<th>#</th>
  			<th>名称</th>
  			<th>商品代码</th>
  			<th>数量</th>
  			<th>价格</th>
  		</tr>
  		
  		<tr>
  			<td>{{ $orders->id }}</td>
  			<td>{{ $orders->name }}</td>
  			<td>{{ $orders->code }}</td>
  			<td>{{ $orders->qty }}</td>
  			<td>{{ $orders->price }}</td>
  		</tr>
	</table>
</div>

@if(count($imglist) > 0)
	
	@foreach($imglist as $value)
	   <img src = "{{ $imgroot }}{{ $value }}" >
	@endforeach
    
	@endif

<script language="javascript" type="text/javascript">
    var LODOP; //声明为全局变量
	//打印图片
   
        
   CreateImage1();
        
        function CreateImage() {
		LODOP=getLodop();  
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_打印图片1");
		LODOP.ADD_PRINT_IMAGE(30,150,400,400,"<img border='0' src='{{ $img }}' />");
		//LODOP.ADD_PRINT_IMAGE(200,150,260,150,"C:/test.jpg"); //本地图片
                
                {{-- 如果指定打印机 --}}
			@if(isset($printid))
				if (LODOP.SET_PRINTER_INDEX({{$printid}})) {
						LODOP.PRINT();
				}
			@else
				{{-- 没有则默认打印机打印 --}}
				LODOP.PRINT();
			@endif
			
	
	};	
        
        function CreateImage1(){
            LODOP=getLodop();  	
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_打印图片3");
                //LODOP.ADD_PRINT_RECT(10,55,227,85,0,1);
                LODOP.SET_PRINT_PAGESIZE (1,2300,360,"");  // 设置打印纸质大小，单位mm(毫米)
		LODOP.ADD_PRINT_IMAGE(15,55,227,85,"<img border='0' src='{{ $img }}' />");//图片
                LODOP.SET_PRINT_STYLEA(0,"Stretch",2);//按原图比例(不变形)缩放模式
                LODOP.ADD_PRINT_BARCODE(20,220,90,58,"128A","{{ $barcode }}"); //条形码
                LODOP.ADD_PRINT_TEXT(90,220,100,25,"{{ $barcode }}");
		
		//LODOP.PREVIEW();
                
                {{-- 如果指定打印机 --}}
                
			@if(isset($printid))
				if (LODOP.SET_PRINTER_INDEX({{$printid}})) {
						LODOP.PRINT();
				}
			@else
				{{-- 没有则默认打印机打印 --}}
				LODOP.PRINT();
			@endif
        }
</script>
       
@stop


