<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadSampleImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download sample bird images for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Downloading sample bird images...');
        
        $images = [
            'african-grey-parrot.jpg' => 'https://example.com/path-to-african-grey-image.jpg',
            'canary.jpg' => 'https://example.com/path-to-canary-image.jpg',
            'budgies.jpg' => 'https://example.com/path-to-budgies-image.jpg',
            'lovebirds.jpg' => 'https://example.com/path-to-lovebirds-image.jpg',
            'cockatiel.jpg' => 'https://example.com/path-to-cockatiel-image.jpg',
        ];
        
        $bar = $this->output->createProgressBar(count($images));
        $bar->start();
        
        foreach ($images as $filename => $url) {
            try {
                $response = Http::get($url);
                
                if ($response->successful()) {
                    Storage::disk('public')->put('annonces/' . $filename, $response->body());
                    $this->info("\nDownloaded: " . $filename);
                } else {
                    $this->error("\nFailed to download: " . $filename);
                }
            } catch (\Exception $e) {
                $this->error("\nError downloading " . $filename . ": " . $e->getMessage());
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nAll sample images have been downloaded.");
    }
}