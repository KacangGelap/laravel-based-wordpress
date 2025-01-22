<?php

namespace App\Helpers;

use HTMLPurifier;
use HTMLPurifier_Config;

class SanitizeHelper
{
    public static function sanitizeIframe(string $iframe): string
    {
        $config = HTMLPurifier_Config::createDefault();
       // Allow iframe tag with specific attributes
        $config->set('HTML.Allowed', 'iframe[src, width, height, style, allowfullscreen, loading, referrerpolicy]');
        
        // Optional: Allow some CSS styles to pass through for iframe (e.g., border)
        $config->set('CSS.AllowedProperties', 'width, height, border, margin, padding');
        $config->set('URI.SafeIframeRegexp', '%^https://www\.google\.com/maps/embed\?pb=%'); // Allow only Google Maps embed URLs

        // Instantiate HTMLPurifier with the configuration
        $purifier = new HTMLPurifier($config);

        return $purifier->purify($iframe);
    }
}