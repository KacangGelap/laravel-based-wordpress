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
            'facebook' => '/^(https?:\/\/)?(www\.)?facebook\.com\/([A-Za-z0-9._-]+|profile\.php\?id=\d+)\/?$/',
            'instagram' => '/^(https?:\/\/)?(www\.)?instagram\.com\/([A-Za-z0-9._-]+)\/?$/',
            'tiktok' => '/^(https?:\/\/)?(www\.)?tiktok\.com\/(@[A-Za-z0-9._-]+|.+\/video\/\d+)\/?$/',
            'x' => '/^(https?:\/\/)?(www\.)?(twitter\.com|x\.com)\/([A-Za-z0-9._-]+)(\/status\/\d+)?\/?$/',
            'youtube' => '/^(https?:\/\/)?(www\.)?youtube\.com\/(@[A-Za-z0-9._-]+|channel\/[A-Za-z0-9_-]+|user\/[A-Za-z0-9_-]+|c\/[A-Za-z0-9_-]+|watch\?v=[A-Za-z0-9_-]+|v\/[A-Za-z0-9_-]+|embed\/[A-Za-z0-9_-]+)$/',
        ];

        foreach ($patterns as $platform => $pattern) {
            if (preg_match($pattern, $value, $matches)) {
                $this->platform = $platform;
                $this->isVideo = $platform === 'youtube' && (strpos($matches[3], 'watch?v=') !== false || strpos($matches[3], 'youtu.be/') !== false);
                 // Extract identifier correctly based on platform
                if ($platform === 'x') {
                    $this->identifier = $matches[4] ?? ''; // X's username is in matches[4]
                } elseif ($platform === 'youtube') {
                    $this->identifier = $this->isVideo ? ($matches[5] ?? '') : ($matches[3] ?? $matches[4] ?? '');
                } else {
                    $this->identifier = $matches[3] ?? ''; // Other platforms use matches[3]
                }
                // dd($this->identifier);
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
