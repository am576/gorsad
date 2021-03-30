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
            'title' => 'required',
            'category_id' => 'required | numeric',
//            'code'  =>  'required | unique:App\Product',
            'description'  =>  'required',
            'price' =>  'required | numeric | max:1000000',
            'discount' => 'numeric | max:100',
            'quantity' => 'numeric | max:1000000',
            'status' => 'required | numeric'
        ];
    }
}
