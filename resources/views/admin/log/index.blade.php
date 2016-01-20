@extends('admin.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3> 日志管理 <small>» 列表 </small></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('admin.partials.errors')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>操作</th>
                            <th>用户</th>
                            <th class="hidden-sm">日期</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($logs as $value)
                        <tr>
                            <td>{{ $value->action }}</td>
                            <td>{{ $value->username }}</td>
                            <td class="hidden-sm">{{ $value->created_at }}</td>
                        
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

