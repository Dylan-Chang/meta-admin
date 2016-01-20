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
	
 <form class="form-group" action="{{ URL('orders/edit') }}" method="POST">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="orderid" value="{{ $orderid }}">
      <p style="font-size:32px;padding-bottom:20px;">备注</p>
      
      <input type="text" id="remark" name="remark" value="" class="form-control" >
      <button type="submit" class="btn btn-lg btn-success col-lg-12" style="display:none;">确认</button>
      
  </form>
</div>

<script>
	$(function(){
　　	$("#barcode").focus(); 
　});
</script>

@endsection