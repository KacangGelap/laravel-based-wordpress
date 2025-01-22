<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SocialMediaUrl implements Rule
{
    public $platform;       // Detected platform name
    public $identifier;     // Extracted username, channel ID, or video ID
    public $isVideo = false; // True if YouTube URL is a video

    public function passes($attribute, $value)
    {
        $patterns = [
            'facebook' => '/^(https?:\/\/)?(www\.)?facebook\.com\/([A-Za-z0-9._-]+)\/?$/',
            'instagram' => '/^(https?:\/\/)?(www\.)?instagram\.com\/([A-Za-z0-9._-]+)\/?$/',
            'tiktok' => '/^(https?:\/\/)?(www\.)?tiktok\.com\/(@[A-Za-z0-9._-]+|.+\/video\/\d+)\/?$/',
            'x' => '/^(https?:\/\/)?(www\.)?(twitter\.com|x\.com)\/([A-Za-z0-9._-]+)(\/status\/\d+)?\/?$/',
            'youtube' => '/^(https?:\/\/)?(www\.)?(youtube\.com\/(channel\/|user\/|c\/|watch\?v=|v\/|embed\/)|youtu\.be\/)([A-Za-z0-9._-]+)$/',
        ];

        foreach ($patterns as $platform => $pattern) {
            if (preg_match($pattern, $value, $matches)) {
                $this->platform = $platform;
                $this->isVideo = $platform === 'youtube' && (strpos($matches[3], 'watch?v=') !== false || strpos($matches[3], 'youtu.be/') !== false);
                $this->identifier = $this->isVideo ? $matches[5] : ($matches[3] ?? $matches[4]);
                return true;
            }
        }

        return false;
    }

    public function message()
    {
        return 'The :attribute must be a valid URL for Facebook, Instagram, TikTok, X, or YouTube.';
    }
    public function extractUsername($value)
    {
        $this->passes(null, $value); // Reuse the validation logic
        return $this->identifier;
    }
}
