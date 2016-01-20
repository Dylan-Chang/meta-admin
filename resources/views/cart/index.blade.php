ID
名称
价格
数量
<br>

<?php
$rs =  Cart::getContent();
foreach($rs as $item)
{
   


?>
   {{ $item->id }} 
    {{ $item->name }}  
   {{ $item->price }} 
   {{ $item->quantity }}
   {{ $item->attributes }}
   <br>
<?php 

}
?>

<a href="{{ url('cart/checkout') }}">确认购买</a>