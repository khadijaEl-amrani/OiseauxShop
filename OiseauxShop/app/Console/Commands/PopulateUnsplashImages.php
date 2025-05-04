<?php

namespace App\Console\Commands;

use App\Models\Annonce;
use App\Models\Image;
use App\Services\UnsplashService;
use Illuminate\Console\Command;

class PopulateUnsplashImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:populate {count=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate announcements with Unsplash bird images';

    /**
     * Execute the console command.
     */
    public function handle(UnsplashService $unsplashService)
    {
        $count = $this->argument('count');
        $this->info("Downloading {$count} bird images from Unsplash...");
        
        $images = $unsplashService->getRandomBirdImages($count);
        
        if (empty($images)) {
            $this->error('Failed to download images from Unsplash.');
            return 1;
        }
        
        $this->info('Downloaded ' . count($images) . ' images.');
        
        // Get announcements without images
        $annonces = Annonce::doesntHave('images')->take(count($images))->get();
        
        if ($annonces->isEmpty()) {
            $this->info('No announcements without images found.');
            return 0;
        }
        
        $this->info('Adding images to ' . $annonces->count() . ' announcements...');
        
        foreach ($annonces as $index => $annonce) {
            if (isset($images[$index])) {
                Image::create([
                    'chemin_image' => $images[$index],
                    'annonce_id' => $annonce->id,
                ]);
                
                $this->info('Added image to announcement: ' . $annonce->titre);
            }
        }
        
        $this->info('Done!');
        return 0;
    }
}