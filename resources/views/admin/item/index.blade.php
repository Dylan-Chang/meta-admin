@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>商品管理 <small>» 列表</small></h3>
                
                
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('admin/itemtype/index') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 商品类型 </a>
                
                <a href="{{ url('admin/item/create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新增 </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>价格</th>
                            <th class="hidden-sm">排序</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($item as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->price }}</td>
                            <td class="hidden-sm">{{ $value->sort }}</td>
                        
                            <td>
                                
                                <a href="{{ url('admin/item/details/'.$value->id) }} " class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 查看
                                </a>
                                
                                <a href="{{ url('admin/item/edit/'.$value->id) }} " class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
								
								<a href="{{ url('admin/item/edit/'.$value->id) }} " class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> 删除
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

@section('scripts')
    <script>
        $(function() {
            $("#tags-table").DataTable({
            });
        });
    </script>
@stop