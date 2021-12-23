<?php

declare(strict_types=1);

namespace Blockpc\Validators;

use Illuminate\Contracts\Validation\Rule;

class AlphaDashSpaces implements Rule
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
        return preg_match('/^[\pL\-\_\s]*$/u', $value) ? trim($value) : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be only letters numbers and spaces.';
    }
}