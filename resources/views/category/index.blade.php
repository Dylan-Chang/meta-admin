
<?php 
foreach ($attrList as $attr){
foreach($attr['attr_list'] as $value){
    
    ?>
   <span>{{ $value['attr_value'] }}</span>

   <?php 
}
?>
<br>
<?php 
}
?>


<?php 
foreach ($itemList as $item){
?>
    <a href="{{ url('item/details') }}"> {{ $item->name }}</a> 
    <a href="{{ url('cart/add/'.$item->id) }}">购买</a><br>
<?php 
}

?>
    

