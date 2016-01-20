
@ foreach ($attr AS $key => $val)

@if ($val->attr_type == 1 || $val->attr_type == 2)
     @if ($spec != $val->attr_id)
      <a href='javascript:;' onclick='addSpec(this)'>[+]</a>
     @else
      <a href='javascript:;' onclick='removeSpec(this)'>[-]</a>
      
     @endif
@endif
{{$val->attr_name}}
<input type='hidden' name='attr_id_list[]' value='$val->attr_id' />