<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the image URL or return a default placeholder if the image doesn't exist
     *
     * @param string|null $path
     * @return string
     */
    public static function getImageUrl($path = null)
    {
        if ($path && file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }
        
        // Return a default placeholder image
        return asset('images/default-bird.png');
    }
}