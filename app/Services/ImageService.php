<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Store the image with specified dimensions and optional subfolder.
     */
    public function storeImage($image, $width, $height, $subfolder = null)
    {
        $image = Image::read($image)->resize($width, $height)->toJpeg();
        $imagePath = "images/" . ($subfolder ? "$subfolder/" : '') . uniqid() . '.jpg';
        Storage::disk('public')->put($imagePath, $image);

        return $imagePath;
    }

    /**
     * Create thumbnail for the uploaded image with specified dimensions and optional subfolder.
     */
    public function storeThumbnail($image, $width, $height, $subfolder = null)
    {
        $thumbnail = Image::read($image)->resize($width, $height)->toJpeg();
        $thumbnailPath = "thumbnails/" . ($subfolder ? "$subfolder/" : '') . uniqid() . '.jpg';
        Storage::disk('public')->put($thumbnailPath, $thumbnail);

        return $thumbnailPath;
    }
}
