<div class="form-group">
    <label for="title" class="col-md-3 control-label">
             名称
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" id="attr_name" value="{{ $role->name }}">
    </div>
</div>

<div class="form-group">
    <label for="title" class="col-md-3 control-label">
             显示名称
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="display_name" id="attr_name" value="{{ $role->display_name }}">
    </div>
</div>

<div class="form-group">
    <label for="title" class="col-md-3 control-label">
             描述
    </label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="desc" id="attr_name" value="{{ $role->desc }}">
    </div>
</div>

<div class="form-group">
   <label for="title" class="col-md-3 control-label">
            权限
    </label> 
    
@foreach( $permissions as $value)
<div class="col-md-1">
{{ $value->display_name }}
    
<input type="checkbox" value="{{ $value->id }}" name="permissions[]" <?php if(isset($permissionRole[$value->id])) echo "checked";?>>

</div>
@endforeach
</div>

<script>
  
    
</script>

