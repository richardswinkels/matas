<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAssemblyRequest;
use App\Http\Resources\AssemblyResource;
use App\Http\Resources\UserAssemblyResource;
use App\Models\Assembly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAssemblyController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $userAssemblies = $user->assemblies()
            ->with('components')
            ->withPivot('quantity', 'created_at', 'updated_at')
            ->paginate(10);

        return UserAssemblyResource::collection($userAssemblies);
    }

    public function store(StoreUserAssemblyRequest $request, Assembly $assembly)
    {
        $validatedData = $request->validated();

        $user = Auth::user();
        $user->assemblies()->attach($assembly->id, [
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json(['message' => 'Assemblies purchased successfully']);
    }
}
