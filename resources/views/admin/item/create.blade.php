@extends('admin.layout')

@section('content')

<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>商品 <small>» 创建</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">创建</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form name="theForm" class="form-horizontal" role="form" method="POST" action="{{ url('admin/item/save') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">类目</label>
                            <div class="col-md-3">

                                <select id="cat_id" name="cat_id" class="form-control" >
                                    <option>请选择</option>
                                    @foreach($category as $value)
                                    <option value="{{ $value->cat_id }}">{{ $value->cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        @include('admin.item._form')

                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label"> 类型</label>
                            <div class="col-md-3">

                                <select id="item_type" name="item_type" class="form-control" onchange="getAttrList()">
                                    <option>请选择</option>
                                    @foreach($itemType as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="itemAttr"></div>
                        </div>
                        <br>

                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <button id="" type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-plus-circle"></i>
                                    确认
                                </button>
                            </div>
                        </div>                                       

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


@stop



<script>


//属性列表					         
    function getAttrList(Id)
    {
        var selGoodsType = document.forms['theForm'].elements['item_type'];

        if (selGoodsType != undefined)
        {
            var goodsType = selGoodsType.options[selGoodsType.selectedIndex].value;
            $.ajax({
                url: "{{url('admin/item/getItemType')}}",
                data: {"itemId": Id, "type": goodsType},
                //type: "POST",   //请求方式
                success: function (result) {
                    document.getElementById('itemAttr').innerHTML = JSON.parse(result);
                }});
            // Ajax.call('goods.php?is_ajax=1&act=get_attr', 'goods_id=' + goodsId + "&goods_type=" + goodsType, setAttrList, "GET", "JSON");
        }
    }

    /**
     * 
     */
    function addSpec(obj)
    {
        var src = obj.parentNode.parentNode;
        var idx = rowindex(src);
        var tbl = document.getElementById('attrTable');
        var row = tbl.insertRow(idx + 1);
        var cell1 = row.insertCell(-1);
        var cell2 = row.insertCell(-1);
        var regx = /<a([^>]+)<\/a>/i;

        cell1.className = 'label';
        cell1.innerHTML = src.childNodes[0].innerHTML.replace(/(.*)(addSpec)(.*)(\[)(\+)/i, "$1removeSpec$3$4-");
        cell2.innerHTML = src.childNodes[1].innerHTML.replace(/readOnly([^\s|>]*)/i, '');
    }

    function removeSpec(obj)
    {
        var row = rowindex(obj.parentNode.parentNode);
        var tbl = document.getElementById('attrTable');

        tbl.deleteRow(row);
    }

    var Browser = new Object();

    Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
    Browser.isIE = window.ActiveXObject ? true : false;
    Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != -1);
    Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != -1);
    Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);

    function rowindex(tr)
    {
        if (Browser.isIE)
        {
            return tr.rowIndex;
        } else
        {
            table = tr.parentNode.parentNode;
            for (i = 0; i < table.rows.length; i++)
            {
                if (table.rows[i] == tr)
                {
                    return i;
                }
            }
        }
    }

</script>


