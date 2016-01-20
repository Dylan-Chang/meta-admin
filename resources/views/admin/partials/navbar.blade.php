<ul class="nav navbar-nav">
   
<!--
    <li @if (Request::is('admin/post*')) class="active" @endif>
         <a class="brand" href="{{ URL('user/index')}}">用户管理</a>

    </li>-->


    <li @if (Request::is('admin/post*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/role/index')}}">权限管理</a>
    </li>

   <li @if (Request::is('admin/orders*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/orders/index')}}">订单管理</a>
    </li>
    <!--
    <li @if (Request::is('admin/category*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/category/index')}}">类目管理</a>
    </li>
    
    
    <li @if (Request::is('admin/itemtype*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/itemtype/index') }}">商品类型</a>
    </li>-->

    <li @if (Request::is('admin/item*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/item/index')}}">商品管理</a>
    </li>
   
 <!--
    <li @if (Request::is('admin/attribute*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/attribute/index')}}">属性管理</a>
    </li>
    -->

    <li @if (Request::is('admin/coupon*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/coupon/index')}}">优惠劵管理</a>
    </li>

    <li @if (Request::is('admin/upload*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/upload')}}">上传管理</a>
    </li>

    
     <li @if (Request::is('admin/tag*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/tag/index') }}">标签管理</a>
    </li>	
    
    <li @if (Request::is('admin/log*')) class="active" @endif>
         <a class="brand" href="{{ URL('admin/log/index') }}">日志管理</a>
    </li>



</ul>

