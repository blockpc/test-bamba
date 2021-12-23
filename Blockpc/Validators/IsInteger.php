<?php

declare(strict_types=1);

namespace Blockpc\Validators;

use Illuminate\Contracts\Validation\Rule;

class IsInteger implements Rule
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
        return ctype_digit(strval($value)) && (int) $value > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El :attribute deberia ser un valor entero y positivo.';
    }
}