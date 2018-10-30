<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HasAtLeastOneDigit implements Rule
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
        $chars = str_split($value);
        foreach ($chars as $char) {
            if (is_numeric($char)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Geslo mora vsebovati vsaj eno številko.';
    }
}
