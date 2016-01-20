@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">标签</div>
                <div class="panel-body">


                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>提示!</strong> 您的输入有问题.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/orders/edit') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="orderid" value="{{ $orderid }}">

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">

                                    @foreach($tags as $value)
                                    <label>
                                        <input type="checkbox" name="tags[]" value="{{ $value->id }}" <?php if(isset($orderTag[$value->id])) echo 'checked'; ?>> {{ $value->name }}
                                    </label>
                                    @endforeach  

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">备注</label>
                            <div class="col-md-6">
                                <input type="remark" class="form-control" name="remark" value="{{ $data->remark }}">

                                <div class="form-group">
                                    <label class="col-md-4 control-label">订单状态</label>
                                    <div class="col-md-6">
                                        <select name="status">
                                            @foreach($status as $key=>$value)
                                            <option value="{{ $key }}" <?php if($data->status == $key) echo 'selected = "selected" '; ?>>{{ $value }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @endsection

