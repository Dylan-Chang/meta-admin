@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>标签 <small>» 列表</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ URL('admin/tag/create')}}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新标签
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')
                @include('admin.partials.success')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            
                            <th>名称</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>
                                <a href="{{ URL('/admin/tag/edit/'.$tag->id) }} " class="btn btn-xs btn-info">
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

@section('scripts')
    <script>
        $(function() {
            $("#tags-table").DataTable({
            });
        });
    </script>
@stop