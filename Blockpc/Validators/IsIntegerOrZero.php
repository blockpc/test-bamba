<?php

declare(strict_types=1);

namespace Blockpc\Validators;

use Illuminate\Contracts\Validation\Rule;

final class IsIntegerOrZero implements Rule
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
        return ctype_digit(strval($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El :attribute deberia ser un valor entero positivo o cero.';
    }
}