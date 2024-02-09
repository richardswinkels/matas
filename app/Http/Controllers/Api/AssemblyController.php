<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssemblyRequest;
use App\Http\Requests\UpdateAssemblyRequest;
use App\Http\Resources\AssemblyResource;
use App\Models\Assembly;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class AssemblyController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $assemblies = Assembly::filter($request->only('search'))
            ->paginate(10);

        return AssemblyResource::collection($assemblies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssemblyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $imagePath = $this->imageService->storeImage($request->file('file'), 400, 400, 'assemblies');
            $thumbnailPath = $this->imageService->storeThumbnail($request->file('file'), 50, 50, 'assemblies');

            $validatedData = array_merge($validatedData, [
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
            ]);
        }

        Assembly::create($validatedData);

        return response()->json(['message' => 'Assembly created successfully'], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssemblyRequest $request, Assembly $assembly): JsonResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $imagePath = $this->imageService->storeImage($request->file('file'), 400, 400, 'assemblies');
            $thumbnailPath = $this->imageService->storeThumbnail($request->file('file'), 50, 50, 'assemblies');

            $validatedData = array_merge($validatedData, [
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
            ]);

//            if ($assembly->image) {
//                Storage::delete($assembly->image);
//            }
//            if ($assembly->thumbnail) {
//                Storage::delete($assembly->thumbnail);
//            }
        }

        $assembly->update($validatedData);

        return response()->json(['message' => 'Assembly updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assembly $assembly): JsonResponse
    {
        $assembly->delete();

        return response()->json(['message' => 'Assembly deleted successfully'], Response::HTTP_OK);
    }
}
