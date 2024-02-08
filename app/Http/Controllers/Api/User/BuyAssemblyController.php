<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAssemblyRequest;
use App\Http\Resources\User\UserAssemblyResource;
use App\Models\Assembly;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BuyAssemblyController extends Controller
{
    public function __invoke(StoreUserAssemblyRequest $request, Assembly $assembly): JsonResponse
    {
        $validatedData = $request->validated();

        $user = Auth::user();
        $user->assemblies()->attach($assembly->id, [
            'quantity' => $validatedData['quantity'],
            'price'    =>  $validatedData['quantity'] * $assembly->price,
        ]);

        return response()->json(['message' => 'Assemblies purchased successfully']);
    }
}
