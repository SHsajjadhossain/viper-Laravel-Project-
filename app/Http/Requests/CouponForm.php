<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponForm extends FormRequest
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
            '*' => 'required',
            'coupon_name' => 'unique:coupons,coupon_name',
            'discount_percentage' => 'numeric|min:1|max:99',
            'validity' => 'date|after:tomorrow',
            'limit' => 'numeric|min:1'
        ];
    }
    public function messages()
    {
        return[
            'limit.numeric' => 'The limit must be number',
            'limit.min:1' => 'The limit at least 1'
        ];
    }
}
