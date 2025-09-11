<?php

namespace App\Features\Properties\Transformers;

use App\Features\AuthManagement\Transformers\ProfileResource;
use App\Features\Regions\Transformers\CityResource;
use App\Features\Regions\Transformers\AreaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = $this->resource;
        $role = Auth::user()?->role;

        $data = [
            'id' => $resource?->id,
            'property_type' => PropertyTypeResource::make($resource?->propertyType),
            'title' => $resource?->title,
            'description' => $resource?->description,
            'address' => $resource?->address,
            'city' => CityResource::make($resource?->city),
            'area' => AreaResource::make($resource?->area),
            'price' => $resource?->price,
            'listing_type' => $resource?->listing_type,
            'status' => $resource?->status,
            'is_active' => $resource?->is_active,
            'images' => $resource?->getMedia('images')->count() > 0 
                ? $resource?->getMedia('images')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                        'name' => $media->name,
                        'size' => $media->size,
                        'mime_type' => $media->mime_type,
                    ];
                })
                : collect([
                    [
                        'id' => null,
                        'url' => asset('img/default property.png'),
                        'name' => 'default property.png',
                        'size' => null,
                        'mime_type' => 'image/png',
                    ],
                    [
                        'id' => null,
                        'url' => asset('img/default property.png'),
                        'name' => 'default property.png',
                        'size' => null,
                        'mime_type' => 'image/png',
                    ],
                    [
                        'id' => null,
                        'url' => asset('img/default property.png'),
                        'name' => 'default property.png',
                        'size' => null,
                        'mime_type' => 'image/png',
                    ]
                ]),
            'features' => PropertyFeatureResource::collection($resource?->features),
            'created_at' => $resource?->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $resource?->updated_at->format('Y-m-d H:i:s'),
        ];

        if ($role == "admin") {
            $data['agent'] =ProfileResource::make($resource?->agent);
            $data['creator'] = ProfileResource::make($resource?->creator);
        }

        return $data;
    }
}
