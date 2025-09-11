<?php

namespace App\Features\Properties\Controllers;

use App\Features\Properties\Models\PropertyType;
use App\Features\Properties\Transformers\PropertyTypeCollection;
use App\Features\Properties\Transformers\PropertyTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Traits\ApiResponses;

class PropertyTypeController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of property types.
     */
    public function index(Request $request): JsonResponse
    {
        $role = auth()->user()->role;
        if ($role !== 'admin') {
            $propertyTypes = PropertyType::query()->where('is_active', true);
        } else {
            $propertyTypes = PropertyType::query();
        }

        // Filter by active status
        if ($request->has('search')) {
            $search = $request->search;
            $propertyTypes->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $propertyTypes = $propertyTypes->paginate($request->get('per_page', 15));

        return $this->okResponse(PropertyTypeCollection::make($propertyTypes), "Property types retrieved successfully");
    }

    /**
     * Store a newly created property type.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:property_types',
            'description' => 'nullable|string'
        ]);

        $propertyType = PropertyType::create($request->only(['name', 'description']));


        return $this->okResponse(PropertyTypeResource::make($propertyType), "Property type created successfully");
    }

    /**
     * Display the specified property type.
     */
    public function show($propertyTypeId): JsonResponse
    {
        $propertyType = PropertyType::findOrFail($propertyTypeId);
        return $this->okResponse(PropertyTypeResource::make($propertyType), "Property type retrieved successfully");
    }

    /**
     * Update the specified property type.
     */
    public function update(Request $request, $propertyTypeId): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:property_types,name,' . $propertyTypeId,
            'description' => 'nullable|string'
        ]);

        $propertyType = PropertyType::findOrFail($propertyTypeId);
        $propertyType->update($request->only(['name', 'description']));

        return $this->okResponse(PropertyTypeResource::make($propertyType), "Property type updated successfully");
    }

    /**
     * Remove the specified property type.
     */
    public function destroy($propertyTypeId): JsonResponse
    {
        $propertyType = PropertyType::findOrFail($propertyTypeId);
        $propertyType->delete();

        return $this->okResponse(null, "Property type deleted successfully");
    }

    /**
     * Change the status of a property type
     */
    public function changeStatus($propertyTypeId): JsonResponse
    {
        $propertyType = PropertyType::find($propertyTypeId);

        if (!$propertyType) {
            return $this->badResponse(
                message: "Property type not found"
            );
        }

        // Toggle the status
        $propertyType->is_active = !$propertyType->is_active;
        $propertyType->save();

        return $this->okResponse(
            PropertyTypeResource::make($propertyType),
            "Property type status changed successfully"
        );
    }
}
