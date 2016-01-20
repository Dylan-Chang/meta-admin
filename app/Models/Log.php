<?php

namespace App\Models;

use Input;
use DB;
use Illuminate\Database\Eloquent\Model;

class Log extends Model {

    protected $table = 'Logs';
    protected $fillable = [
        'action','userid','username'
    ];
}
