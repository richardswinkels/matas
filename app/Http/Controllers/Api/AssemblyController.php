<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssemblyResource;
use App\Models\Assembly;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssemblyController extends Controller
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
        $assemblies = Assembly::filter($request->only('search'))
            ->paginate(10);

        return AssemblyResource::collection($assemblies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $imagePath = $this->imageService->storeImage($request->file('file'), 400, 400, 'assemblies');
            $thumbnailPath = $this->imageService->storeThumbnail($request->file('file'), 50, 50, 'assemblies');

            $validatedData = array_merge($validatedData, [
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
            ]);
        }

        $assembly = Assembly::create($validatedData);

        return response()->json(['message' => 'Assembly created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assembly $assembly)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $imagePath = $this->imageService->storeImage($request->file('file'), 400, 400, 'assemblies');
            $thumbnailPath = $this->imageService->storeThumbnail($request->file('file'), 50, 50, 'assemblies');

            $validatedData = array_merge($validatedData, [
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
            ]);

            if ($assembly->image) {
                Storage::delete($assembly->image);
            }
            if ($assembly->thumbnail) {
                Storage::delete($assembly->thumbnail);
            }
        }

        $assembly->update($validatedData);

        return response()->json(['message' => 'Assembly updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assembly $assembly)
    {
        $assembly->delete();

        return response()->json(['message' => 'Assembly deleted successfully'], 200);
    }
}
