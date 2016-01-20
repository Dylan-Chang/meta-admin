@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>分类管理 <small>» 分类列表</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="/admin/tag/create" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> 新增               </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>分类名称</th>
                            <th class="hidden-sm">排序</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($cat as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td class="hidden-sm">{{ $value->sort }}</td>
                        
                            <td>
                                <a href="/admin/tag/{{ $value->id }}/edit" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> Edit
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