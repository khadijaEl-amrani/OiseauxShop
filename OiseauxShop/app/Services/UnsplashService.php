<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UnsplashService
{
    protected $accessKey;
    
    public function __construct()
    {
        $this->accessKey = config('services.unsplash.access_key');
    }
    
    /**
     * Get random bird images from Unsplash
     *
     * @param int $count
     * @return array
     */
    public function getRandomBirdImages($count = 5)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . $this->accessKey
        ])->get('https://api.unsplash.com/photos/random', [
            'query' => 'bird',
            'count' => $count,
            'orientation' => 'landscape'
        ]);
        
        if ($response->successful()) {
            $images = [];
            foreach ($response->json() as $image) {
                $imageUrl = $image['urls']['regular'];
                $filename = 'bird-' . uniqid() . '.jpg';
                $path = 'annonces/' . $filename;
                
                // Download and save the image
                $imageContent = file_get_contents($imageUrl);
                Storage::disk('public')->put($path, $imageContent);
                
                $images[] = $path;
            }
            
            return $images;
        }
        
        return [];
    }
}