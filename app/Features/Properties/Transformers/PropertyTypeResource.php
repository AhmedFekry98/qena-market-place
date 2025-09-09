<?php

namespace App\Features\Properties\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = $this->resource;
        return [
            'id' => $resource?->id,
            'name' => $resource?->name,
            'description' => $resource?->description,
            'created_at' => $resource?->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource?->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
