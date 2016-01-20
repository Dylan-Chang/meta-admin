<?php
/**
 * 
 */
namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model
{ 
    public $timestamps = true;

    
	/**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
     public function getDateFormat() {
       return 'U';
     }
}