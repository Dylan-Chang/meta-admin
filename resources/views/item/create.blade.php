@extends('layouts.default')

@section('main')
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">添加商品</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('item/save') }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">商品名称</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">分类</label>
							<div class="col-md-6">
							     <select name="cat_id">
							         <option>请选择</option>
							         @foreach($itemCat as $value)
							            <option>{{ $value->name }}</option>
							         @endforeach
							     </select>
								
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">sku</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="sku" value="">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">价格</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="price" value="">
							</div>
						</div>

	                    <div class="form-group">
							<label class="col-md-4 control-label">上传logo</label>
							<div class="col-md-9">
								<input type="text"  name="text" value=""><input type="file"  name="logo" value="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									保存
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection