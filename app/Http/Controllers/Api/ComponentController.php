<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComponentRequest;
use App\Http\Requests\UpdateComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
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
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Component::filter($request->only('search'));

        if ($request->has('page')) {
            $components = $query->paginate(10);
        } else {
            $components = $query->get();
        }

        return ComponentResource::collection($components);
    }

    public function show(Component $component): ComponentResource
    {
        return new ComponentResource($component);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponentRequest $request): JsonResponse
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

        return response()->json(['message' => 'Component created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponentRequest $request, Component $component): JsonResponse
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

        return response()->json(['message' => 'Component updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component): JsonResponse
    {
        $component->delete();

        return response()->json(['message' => 'Component deleted successfully'], Response::HTTP_OK);
    }
}
