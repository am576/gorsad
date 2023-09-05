<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string | required | max:255',
            'title_lat' => 'string | max:255',
            'category_id' => 'required | integer | min:0 | max: 255',
//            'code'  =>  'required | unique:App\Product',
            'description'  =>  'required | string |max: 3000',
            'price' =>  'required | integer | max: 1000000',
            'discount' => 'integer | min:0 | max:100',
            'quantity' => 'integer | min:0 | max:10000',
            'status' => 'required | boolean'
        ];
    }
}
