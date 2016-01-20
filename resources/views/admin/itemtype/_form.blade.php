<div class="form-group">
    <label for="title" class="col-md-3 control-label">
             名称
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="name" id="name" value="{{ $name }}">
    </div>
</div>


<div class="form-group">
    <label for="meta_description" class="col-md-3 control-label">
         分组  </label>
    <div class="col-md-8">
        <textarea class="form-control" id="desc" name="desc" rows="3">
            {{ $attr_group }}
        </textarea>
    </div>
</div>


<div class="form-group">
    <label for="reverse_direction" class="col-md-3 control-label">
        状态
    </label>
    <div class="col-md-7">
        <label class="radio-inline">
            <input type="radio" name="reverse_direction" id="reverse_direction"
                    @if (! $status)
                        checked="checked"
                    @endif
                     value="0"> 
             下架
        </label>
        <label class="radio-inline">
            <input type="radio" name="reverse_direction"
                @if ($status)
                    checked="checked"
                @endif
                value="1"> 
            上架
        </label>
    </div>
</div>