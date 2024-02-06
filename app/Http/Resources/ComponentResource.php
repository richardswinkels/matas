<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
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
            'type' => $this->type,
            'price' => $this->price,
            'image' => $this->image,
            'thumbnail' => $this->thumbnail,
            'manufacturer' => new ManufacturerResource($this->manufacturer),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
