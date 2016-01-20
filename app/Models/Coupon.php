<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';

    protected $fillable = ['name', 'money','min_amount','max_amount'];
}
