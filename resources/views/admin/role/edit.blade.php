@extends('admin.layout')


@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>角色 <small>» 编辑</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> 编辑 </h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')
                    @include('admin.partials.success')

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.role.update', $role->id) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('admin.role._form')

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
        
                                    <button type="submit" class="btn btn-success btn-lg" name="action" value="finished">
                                        <i class="fa fa-floppy-o"></i>
                                                                                                                保存
                                    </button>
                                </div>
                            </div>
                        </div>
 
                    </form>

                </div>
            </div>
        </div>
    </div>

  
</div>

@stop

