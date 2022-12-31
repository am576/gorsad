<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[ a-zA-Z\p{Cyrillic}]*$/u|max:64',
            'email' => 'required|email|max:64',
            'phone' => 'max:32|regex:/^([+\d]?)(?:([ \(\)-])?[\d]+([ \(\)-])?)+$/',
            'message' => 'required|max:1000'
        ];
    }
}
