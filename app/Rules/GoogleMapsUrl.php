<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GoogleMapsUrl implements Rule
{
    public $locationId;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Regex to extract the location ID from the URL
        $regex = '/^https?:\/\/maps\.app\.goo\.gl\/([A-Za-z0-9_-]+)$/';

        if (preg_match($regex, $value, $matches)) {
            $this->locationId = $matches[1]; // Extracted location ID
            return true;
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
        return 'The :attribute must be a valid Google Maps URL.';
    }
}
