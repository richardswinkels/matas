<?php

namespace Tests\Integration;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    public ImageService $imageService;

    public function setUp(): void
    {
        parent::setUp();

        $this->imageService = new ImageService();
    }

    public function test_it_stores_an_image_with_specified_dimensions(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('image.jpg');
        $imagePath = $this->imageService->storeImage($image, 400, 400);

        Storage::disk('public')->assertExists($imagePath);

        [$storedWidth, $storedHeight] = getimagesizefromstring(Storage::disk('public')->get($imagePath));
        $this->assertEquals(400, $storedWidth);
        $this->assertEquals(400, $storedHeight);
    }

    public function test_it_stores_a_thumbnail_with_specified_dimensions(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('image.jpg');
        $width = 100;
        $height = 100;
        $thumbnailPath = $this->imageService->storeThumbnail($image, $width, $height);

        Storage::disk('public')->assertExists($thumbnailPath);

        [$storedWidth, $storedHeight] = getimagesizefromstring(Storage::disk('public')->get($thumbnailPath));
        $this->assertEquals($width, $storedWidth);
        $this->assertEquals($height, $storedHeight);
    }
}
