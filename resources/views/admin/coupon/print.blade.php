@extends('admin.layout')

@section('content')

<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>优惠劵 <small>» 发放</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">发放</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form name="theForm" class="form-horizontal" role="form" method="POST" action="{{ url('admin/coupon/sendPrint') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                    
                                
							      <div class="form-group">
							    <label for="subtitle" class="col-md-3 control-label">
        数量
    </label>
    <div class="col-md-2">
        <input type="text" class="form-control" name="qty" id="qty" value="" size="30" maxlength="6" />
    </div>
							   
							   
							     </div>
  <br>
							     
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button id="" type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        确认
                                    </button>
                                </div>
                            </div>                                       
                           
                        </form>
                

                 </div>
             </div>
        </div>
    </div>
</div>


@stop