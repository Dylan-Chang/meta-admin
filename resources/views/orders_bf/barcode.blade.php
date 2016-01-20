@extends('_layouts.default')

@section('main')

<style>
#barcode {
		font-size:32px;
		height:50px;
		width:400px;
}
</style>

<div class="row">
	
 <form class="form-group" action="{{route('order.barcodeInfo', ['printid' => $printid])}}" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      
      <p style="font-size:32px;padding-bottom:20px;">请扫描商品条形码</p>
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

<script>
	$(function(){
　　	$("#barcode").focus(); 
　});
</script>

@endsection
