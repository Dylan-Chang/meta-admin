@foreach($itemType as $value)
    <div class="form-group">
    <label for="title" class="col-md-3 control-label">
             属性名称
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="name" id="name" value="{{ $name }}">
    </div>
</div>
@endforeach