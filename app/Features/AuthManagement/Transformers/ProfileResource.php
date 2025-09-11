<?php

namespace App\Features\AuthManagement\Transformers;

use App\Features\SystemManagements\Transformers\PermissionResource;
use App\Features\SystemManagements\Transformers\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = $this->resource;
        $role = $resource?->role;
        return [
            'id' => $resource?->id,
            'name' => $resource?->name,
            'phone_code' => $resource?->phone_code,
            'phone' => $resource?->phone,
            'image' => $resource?->getFirstMediaUrl('user-image'),
            'role' => $role,
            // 'permissions' => PermissionResource::collection($resource?->allPermissions())->pluck('name'),
            'created_at' => $resource?->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $resource?->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
