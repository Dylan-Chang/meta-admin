<?php
namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Queue extends Eloquent
{
    public $timestamps = false;
    
    protected $table = 'queues';
    
    /**
     * The model name.
     *
     * @var string
     */
    public static $name = 'queue';

    /**
     * The revisionable columns.
     *
     * @var array
     */
    protected $keepRevisionOf = ['type', 'content', 'status'];
    
   


}