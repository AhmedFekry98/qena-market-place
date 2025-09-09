<?php

namespace App\Features\Regions\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name_ar' => $resource?->name_ar,
            'code' => $resource?->code,
            'is_active' => $resource?->is_active,
            // 'areas' => AreaResource::collection($resource?->areas),
            'created_at' => $resource?->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource?->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
