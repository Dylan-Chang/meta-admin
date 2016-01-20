<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $table = 'Cart';
    
    protected $fillable = ['session_id', 'item_name','user_id','item_price','item_number','id'];
}
