<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class YoutubeUrl implements Rule
{
    public $videoId;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regex = '/^(?:https?\:\/\/)?(?:www\.youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})$/';

        if (preg_match($regex, $value, $matches)) {
            $this->videoId = $matches[1]; // Extract video ID
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
        return 'The :attribute must be a valid YouTube URL.';
    }
}
