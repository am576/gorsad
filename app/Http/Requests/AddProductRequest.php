<?php

namespace App\Http\Requests;

use App\Rules\ProductExists;
use App\Rules\VariantExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddProductRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'product_id' => ['required', 'numeric', new ProductExists],
            'quantity' => 'required|numeric|min:1|max:100',
            'variant_id' => ['required', 'numeric', new VariantExists]
        ];
    }
}
