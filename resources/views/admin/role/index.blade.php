@extends('admin.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3> 权限管理 <small>» 角色列表 </small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('admin/role/create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"> 添加角色 </i>  </a>
                 <a href="{{ url('admin/permission/index') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"> 权限列表 </i>  </a> 
                    
            </div>
            
            
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>显示名称</th>
                            <th class="hidden-sm">描述</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($role as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->display_name }}</td>
                            <td class="hidden-sm">{{ $value->description }}</td>
                        
                            <td>
                                <a href="{{ url('admin/role/edit/'.$value->id) }} " class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

