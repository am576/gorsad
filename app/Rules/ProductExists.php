<?php

namespace App\Rules;

use App\Product;
use Illuminate\Contracts\Validation\Rule;

class ProductExists implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return Product::where('id', $value)->exists();
    }

    public function message()
    {
        return 'Product does not exist.';
    }
}
