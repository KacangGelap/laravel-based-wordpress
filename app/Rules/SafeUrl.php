<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SafeUrl implements Rule
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
        // Parse the URL
        $parsedUrl = parse_url($value);

        if (!$parsedUrl || !isset($parsedUrl['scheme'], $parsedUrl['host'])) {
            return false; // Invalid URL
        }

        // Check if the scheme is HTTP or HTTPS
        if (!in_array($parsedUrl['scheme'], ['http', 'https'])) {
            return false;
        }

        // Block dangerous schemes
        if (\Str::startsWith($value, ['javascript:', 'data:', 'file:'])) {
            return false;
        }

        // Validate DNS resolution
        $host = $parsedUrl['host'];
        $ip = gethostbyname($host);

        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return false; // Unsafe IP (e.g., private or reserved ranges)
        }

        // Check for XSS patterns
        $xssPatterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is', // Detect <script> tags
            '/on\w+="[^"]*"/i',                  // Inline event handlers
            '/javascript:/i',                    // JavaScript schemes
            '/data:text\/html/i',                // Data schemes
        ];

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false; // XSS payload detected
            }
        }

        // Allow paths, but block risky file extensions
        $path = $parsedUrl['path'] ?? '';
        $blockedExtensions = ['.php', '.exe', '.js', '.html', '.sh', '.bat']; // Add more as needed

        foreach ($blockedExtensions as $ext) {
            if (\Str::endsWith($path, $ext)) {
                return false; // Block dangerous file types
            }
        }

        // Optionally, allow only specific paths (whitelist)
        $allowedExtensions = ['.pdf', '.jpg', '.png', '.txt']; // Optional
        $allowOnlySpecificPaths = false; // Toggle strict path control

        if ($allowOnlySpecificPaths && !\Str::endsWith($path, $allowedExtensions)) {
            return false; // Block if not in the allowed list
        }

        return true; // URL is safe
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid URL.';
    }
}
