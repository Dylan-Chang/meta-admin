<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="form-group">
    <label for="title" class="col-md-3 control-label">
             名称
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="name" id="name" value="{{ $data['name'] }}">
    </div>
</div>

<div class="form-group">
    <label for="title" class="col-md-3 control-label">
        金额
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="money" id="money" value="{{ $data['money'] }}">
    </div>
</div>

<div class="form-group">
    <label for="subtitle" class="col-md-3 control-label">
           使用起始日期
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" id="use_start_date" name="use_start_date"  value="{{ $data['use_start_date'] }}" id="datetimepicker">
    </div>
</div>


<div class="form-group">
    <label for="layout" class="col-md-3 control-label">
       使用结束日期
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" id="use_end_date" name="use_end_date"  value="{{ $data['use_end_date'] }}" id="datetimepicker">
    </div>
</div>

<div class="form-group">
    <label for="reverse_direction" class="col-md-3 control-label">
    发放类型
    </label>
    <div class="col-md-7">
        <label class="radio-inline">
            <input type="radio" name="reverse_direction" id="reverse_direction"
                    @if (! $data['send_type'])
                        checked="checked"
                    @endif
                     value="0"> 
             下架
        </label>
        <label class="radio-inline">
            <input type="radio" name="reverse_direction"
                @if ($data['send_type'])
                    checked="checked"
                @endif
                value="1"> 
            上架
        </label>
    </div>
</div>

	<script>
  $(function(){
			//window.prettyPrint && prettyPrint();
			$('#use_start_date').datepicker({
				language: 'zh-CN'
			});
			
			$('#use_end_date').datepicker({
				language: 'zh-CN'
			});
			
	
		});
		
	
</script>


		
	

