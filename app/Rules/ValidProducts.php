<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidProducts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passes = true;
        if(!count($value) || !isset($value[0]['id']) || !isset($value[0]['variants']))
        {
            $passes = false;
        }

        return $passes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given products are invalid.';
    }
}
