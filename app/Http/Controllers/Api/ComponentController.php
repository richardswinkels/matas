<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComponentRequest;
use App\Http\Requests\UpdateComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComponentController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $components = Component::filter($request->only('search'))
            ->paginate(10);

        return ComponentResource::collection($components);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponentRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $imagePath = $this->imageService->storeImage($request->file('file'), 400, 400, 'components');
            $thumbnailPath = $this->imageService->storeThumbnail($request->file('file'), 50, 50, 'components');

            $validatedData = array_merge($validatedData, [
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
            ]);
        }

        Component::create($validatedData);

        return response()->json(['message' => 'Component created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponentRequest $request, Component $component)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $imagePath = $this->imageService->storeImage($request->file('file'), 400, 400, 'components');
            $thumbnailPath = $this->imageService->storeThumbnail($request->file('file'), 50, 50, 'components');

            $validatedData = array_merge($validatedData, [
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
            ]);

            if ($component->image) {
                Storage::delete($component->image);
            }
            if ($component->thumbnail) {
                Storage::delete($component->thumbnail);
            }
        }

        $component->update($validatedData);

        return response()->json(['message' => 'Component updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component)
    {
        $component->delete();

        return response()->json(['message' => 'Component deleted successfully'], 200);
    }
}
