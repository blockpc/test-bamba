<?php

declare(strict_types=1);

namespace Blockpc\Validators;

use Illuminate\Contracts\Validation\Rule;

class IsDecimal implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ( !is_numeric($value) ) {
            return false;
        }
        return is_float($value + 0)  && $value + 0 >= 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El :attribute deberia ser un valor decimal y positivo.';
    }
}