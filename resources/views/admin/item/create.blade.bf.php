@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>商品 <small>» 创建</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">创建</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/item/save') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">分类</label>
                                <div class="col-md-3">
                               
                                     <select id="cat_id" name="cat_id" class="form-control" >
							         <option>请选择</option>
							         @foreach($cat_id as $value)
							            <option value="{{ $value->id }}">{{ $value->name }}</option>
							         @endforeach
							     </select>
                                    
                                </div>
                            </div>

                            @include('admin.item._form')

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
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

