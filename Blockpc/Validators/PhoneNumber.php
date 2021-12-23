<?php

declare(strict_types=1);

namespace Blockpc\Validators;

use Illuminate\Contracts\Validation\Rule;

final class PhoneNumber implements Rule
{
    protected $pattern = '/^(\+[\d]{1,2}+(\s)?)?+[\d]{8,12}$/';
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //dd(preg_match($this->pattern, $value) ? true : false);
        return preg_match($this->pattern, $value) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El :attribute deberia ser un número de teléfono valido.';
    }
}