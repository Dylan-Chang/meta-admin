@extends('admin.layout')

@section('content')
 <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="{{ URL::asset('js/script.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.zh-CN.js') }}" charset="UTF-8"></script>

<link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>优惠劵 <small>» 新增</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">新增</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form name="theForm" class="form-horizontal" role="form" method="POST" action="{{ url('admin/coupon/store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            @include('admin.coupon._form')
                                
							      <div class="form-group">
							     <div id="itemAttr"></div>
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


