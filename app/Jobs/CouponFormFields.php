<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Coupon;
use Illuminate\Contracts\Bus\SelfHandling;

class CouponFormFields extends Job implements SelfHandling
{
    protected $id;
    
    protected $fieldList = [
        'name' => '',
        'money' => '',
        'use_start_date' => '',
        'use_end_date' => '',
    ];
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $fields = $this->fieldList;
        
        if ($this->id) {
            $fields = $this->fieldsFromModel($this->id, $fields);
        } 
        
        foreach ($fields as $fieldName => $fieldValue) {
            $fields[$fieldName] = old($fieldName, $fieldValue);
        }
        
        return $fields;
    }
    
    /**
     * Return the field values from the model
     *
     * @param integer $id
     * @param array $fields
     * @return array
     */
    protected function fieldsFromModel($id, array $fields)
    {
        $post = Coupon::findOrFail($id);
    
        $fieldNames = $fields;
    
        $fields = ['id' => $id];
        foreach ($fieldNames as $field) {
            $fields[$field] = $post->{$field};
        }
    
    
        return $fields;
    }
}
