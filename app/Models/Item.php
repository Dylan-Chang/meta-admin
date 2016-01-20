<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends BaseModel {

    protected $table = 'item';
    protected $fillable = ['name', 'sort', 'sku', 'qty', 'status', 'logo'];

}
