<?php

namespace App\Features\Properties\Controllers;

use App\Features\Properties\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of property types.
     */
    public function index(): JsonResponse
    {
        $propertyTypes = PropertyType::with('properties')->get();
        
        return response()->json([
            'success' => true,
            'data' => $propertyTypes
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Property type created successfully',
            'data' => $propertyType
        ], 201);
    }

    /**
     * Display the specified property type.
     */
    public function show(PropertyType $propertyType): JsonResponse
    {
        $propertyType->load(['properties' => function ($query) {
            $query->with(['images', 'features']);
        }]);

        return response()->json([
            'success' => true,
            'data' => $propertyType
        ]);
    }

    /**
     * Update the specified property type.
     */
    public function update(Request $request, PropertyType $propertyType): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:property_types,name,' . $propertyType->id,
            'description' => 'nullable|string'
        ]);

        $propertyType->update($request->only(['name', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Property type updated successfully',
            'data' => $propertyType
        ]);
    }

    /**
     * Remove the specified property type.
     */
    public function destroy(PropertyType $propertyType): JsonResponse
    {
        $propertyType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property type deleted successfully'
        ]);
    }
}
