<?php

namespace App\Http\Controllers\Api\Assembly;

use App\Http\Controllers\Controller;
use App\Http\Resources\Assembly\AssemblyComponentResource;
use App\Models\Assembly;
use App\Models\Component;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class AssemblyComponentController extends Controller
{
    public function store(Assembly $assembly, Component $component): JsonResponse {
        $assembly->components()->attach($component);

        return response()->json(['message' => 'Component successfully added'], 201);
    }

    public function show(Assembly $assembly): JsonResource {
        return AssemblyComponentResource::collection($assembly->components);
    }

    public function destroy(Assembly $assembly, Component $component): JsonResponse {
        $assembly->components()->detach($component);

        return response()->json(['message' => 'Component successfully removed'], 201);
    }
}
