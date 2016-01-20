<!DOCTYPE html>
<html>
<head>
<meta name="_token" content="{{ csrf_token() }}"/>
<title>后台管理</title>
<script src="{{ URL::asset('js/jquery-1.9.1.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/script.js') }}"></script>

<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">

@yield('headjs')
</head>
<body>
	<div class="container">
			<div class="navbar navbar-inverse navbar-fixed-top">
					<div class="navbar-inner">
								<div class="container">
										<a class="brand" href="{{ URL()}}">管理中心</a>
										<a class="brand" href="{{ URL('user/index')}}">用户管理</a>
										<a class="brand" href="{{ URL('orders/index')}}">订单管理</a>
										<a class="brand" href="{{ URL('admin/Log/index')}}">日志管理</a>
										
                                                                                <!--
										<a class="brand" href="{{ URL('item/index')}}">商品管理</a>
										<a class="brand" href="{{ URL()}}">合作渠道管理</a>
										<a class="brand" href="{{ URL()}}">优惠劵管理</a>
										<a class="brand" href="{{ URL()}}">图片管理</a>-->
										
										<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ URL('/auth/login') }}">登录</a></li>
						<li><a href="{{ URL('/auth/register') }}">注册</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('auth/logout') }}">退出登录</a></li>
							</ul>
						</li>
					@endif
				</ul>
										
								</div>
					</div>
			</div>


	@yield('main')

	</div>
	
</body>
</html>