<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class WatermarkService
{
    /**
     * Add watermark to an image
     *
     * @param string $imagePath
     * @return void
     */
    public function addWatermark($imagePath)
    {
        $image = Image::make(storage_path('app/public/' . $imagePath));
        
        // Add text watermark
        $image->text('BirdFinder.com', $image->width() - 20, $image->height() - 20, function($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(24);
            $font->color([255, 255, 255, 0.6]);
            $font->align('right');
            $font->valign('bottom');
        });
        
        // Save the image
        $image->save(storage_path('app/public/' . $imagePath));
    }
}