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
            'code'  =>  'required',
            'description'  =>  'required',
            'price' =>  'required | numeric | max:1000000',
            'discount' => 'numeric | max:100',
            'quantity' => 'required | numeric | max:1000000',
            'status' => 'required | numeric'
        ];
    }
}
