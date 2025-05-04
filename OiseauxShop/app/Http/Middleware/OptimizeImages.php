<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class OptimizeImages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $image = Image::make($imageFile->path());
                
                // Resize if larger than 1200px width
                if ($image->width() > 1200) {
                    $image->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                
                // Save with reduced quality
                $image->save($imageFile->path(), 80);
            }
        }
        
        return $response;
    }
}