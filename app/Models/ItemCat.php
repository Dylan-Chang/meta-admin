<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCat extends Model
{
    //
	protected $table = 'item_cat';
    
    protected $fillable = ['name', 'sort'];
}
