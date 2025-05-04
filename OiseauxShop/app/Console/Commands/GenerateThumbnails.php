<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Intervention\Image\Facades\Image as ImageIntervention;
use Illuminate\Support\Facades\Storage;

class GenerateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:thumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for all images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $images = Image::all();
        $bar = $this->output->createProgressBar(count($images));
        $bar->start();
        
        foreach ($images as $image) {
            $originalPath = $image->chemin_image;
            $thumbnailPath = $this->generateThumbnailPath($originalPath);
            
            try {
                if (Storage::disk('public')->exists($originalPath)) {
                    $img = ImageIntervention::make(storage_path('app/public/' . $originalPath));
                    $img->fit(200, 200);
                    $img->save(storage_path('app/public/' . $thumbnailPath));
                    
                    // Update the image record with thumbnail path
                    $image->update([
                        'thumbnail_path' => $thumbnailPath
                    ]);
                }
            } catch (\Exception $e) {
                $this->error("\nError processing image {$originalPath}: {$e->getMessage()}");
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nAll thumbnails have been generated.");
    }
    
    /**
     * Generate thumbnail path from original path
     *
     * @param string $originalPath
     * @return string
     */
    private function generateThumbnailPath($originalPath)
    {
        $pathInfo = pathinfo($originalPath);
        return $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    }
}