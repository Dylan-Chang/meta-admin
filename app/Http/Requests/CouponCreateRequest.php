<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;//DateTime API 的一个简单扩展。

class CouponCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'money' => 'required',
            'use_start_date' => 'required',
            'use_end_date' => 'required'
        ];
    }
    

    /**
     * 填充数据
     */
    public function fillData()
    {
        return [
            'name' => $this->name,
            'money' => $this->money,
            'use_start_date' => $this->use_start_date,
            'use_end_date' => $this->get('use_end_date'),
        ];
    }
}
