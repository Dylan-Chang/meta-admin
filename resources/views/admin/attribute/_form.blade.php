<div class="form-group">
    <label for="title" class="col-md-3 control-label">
        属性名称
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="attr_name" id="attr_name" value="{{ $attr_name }}">
    </div>
</div>

<div class="form-group">
    <label for="subtitle" class="col-md-3 control-label">
        分类
    </label>
    <div class="col-md-8">
        <select id="cat_id" name="cat_id" class="form-control" >
            <option>请选择</option>
            @foreach($attr_type as $value)
            <option value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="reverse_direction" class="col-md-3 control-label">
        该属性值的录入方式：
    </label>
    <div class="col-md-7">
        <label class="radio-inline">
            <input type="radio" onclick="radioClicked(0)" checked="true" value="0"  name="attr_input_type"
                   @if (! $attr_input_type)
                   checked="checked"
                   @endif>

                   手工录入
        </label>
        <label class="radio-inline">
            <input type="radio" onclick="radioClicked(1)" value="1" name="attr_input_type"
                   @if ($attr_input_type)
                   checked="checked"
                   @endif>
                   从下面的列表中选择（一行代表一个可选值） 

        </label>
        <label class="radio-inline">
            <input type="radio" onclick="radioClicked(2)" value="2" name="attr_input_type"
                   @if ($attr_input_type)
                   checked="checked"
                   @endif>
                   多行文本框 
        </label>
    </div>
</div>

<div class="form-group">
    <label for="title" class="col-md-3 control-label">
        可选值列表： 	
    </label>
    <div class="col-md-8">
        <textarea rows="5" cols="30" name="attr_values" disabled=""></textarea>
    </div>
</div>

<script>

    /**
     * 点击类型按钮时切换选项的禁用状态
     */
    function radioClicked(n)
    {
        document.forms['theForm'].elements["attr_values"].disabled = n > 0 ? false : true;
    }
</script>
