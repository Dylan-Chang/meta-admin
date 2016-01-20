@extends('layouts.default')

@section('main')
<a class="brand" href="">分类管理</a>

 <form action="{{ URL('itemCat/save')}}" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          分类名称 <input type="text" id="name" name="name" class="form-control" >
          <br>
                 排序 <input type="text" id="sort" name="sort" class="form-control" >
                 <br>
          <button type="submit" class="btn btn-lg btn-success col-lg-12">确认</button>
  </form>
			
@endsection
