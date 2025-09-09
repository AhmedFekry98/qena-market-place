<?php

namespace App\Features\SystemManagements\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $group = $request->get('group');

        // If group=true, return grouped permissions
        if ($group === 'true') {
            return $this->getGroupedResponse($request);
        }

        // Regular response
        return [
            'per_page' => $this->collection->count(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'next_page_url' => $this->nextPageUrl(),
            'items' => PermissionResource::collection($this->collection),
        ];
    }

    /**
     * Get grouped permissions response
     */
    private function getGroupedResponse(Request $request): array
    {
        $grouped = $this->collection->groupBy('group')->map(function ($groupPermissions, $groupName) {
            return [
                'name' => $groupName,
                'permissions' => $groupPermissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'caption' => $permission->caption,
                        'createdAt' => $permission->created_at?->format('Y-m-d H:i:s'),
                        'updatedAt' => $permission->updated_at?->format('Y-m-d H:i:s'),
                    ];
                })->values()
            ];
        })->values();

        return [
            'per_page' => $this->collection->count(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'next_page_url' => $this->nextPageUrl(),
            'items' => $grouped->map(function ($group, $index) {
                return [
                    'id' => $index + 1,
                    'group' => $group
                ];
            })
        ];
    }
}
