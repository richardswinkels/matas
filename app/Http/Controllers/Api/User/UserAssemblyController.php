<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAssemblyRequest;
use App\Http\Resources\User\UserAssemblyResource;
use App\Models\Assembly;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserAssemblyController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();

        $userAssemblies = $user->assemblies()
            ->withPivot('quantity', 'created_at')
            ->orderByPivot('created_at', 'desc')
            ->paginate(10);

        return UserAssemblyResource::collection($userAssemblies);
    }
}
