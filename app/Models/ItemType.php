<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    //
	protected $table = 'item_type';
    
    protected $fillable = ['name', 'status','attr_group'];
    
    public function attribute()
    {
        return $this->hasMany('App\Attribute');
    }
}
