<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        return new ComponentResource($component);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Component $component)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

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
