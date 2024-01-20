<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordComplex implements Rule
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
        // Check if the value is confirmed and has a minimum length of 6 characters
        return \Illuminate\Support\Str::length($value) >= 6 && \Illuminate\Support\Facades\Request::input('password_confirmation') === $value;
    }

    public function message()
    {
        return 'The password must be at least 6 characters long and match.';
    }
}
