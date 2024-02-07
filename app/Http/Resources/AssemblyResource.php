<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssemblyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image,
            'thumbnail' => $this->thumbnail,
            'components' => ComponentResource::collection($this->whenLoaded('components')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
