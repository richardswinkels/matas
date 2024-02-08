<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssemblyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'assembly' => new AssemblyResource($this),
            'quantity' => $this->pivot->quantity,
            'created_at' => $this->pivot->created_at,
            'updated_at' => $this->pivot->updated_at,
        ];
    }
}
