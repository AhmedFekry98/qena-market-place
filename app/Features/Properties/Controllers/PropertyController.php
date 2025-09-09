<?php

namespace App\Features\Properties\Controllers;

use App\Features\Properties\Models\Property;
use App\Features\Properties\Requests\PropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Property::with(['propertyType', 'images', 'features']);

        // Filter by property type
        if ($request->has('property_type_id')) {
            $query->ofType($request->property_type_id);
        }

        // Filter by city
        if ($request->has('city')) {
            $query->inCity($request->city);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->available(); // Default to available properties
        }

        // Filter by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        // Search in title and description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $properties = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $properties
        ]);
    }

    /**
     * Store a newly created property.
     */
    public function store(PropertyRequest $request): JsonResponse
    {

        $property = Property::create([
            'property_type_id' => $request->property_type_id,
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'price' => $request->price,
            'area' => $request->area,
            'status' => $request->get('status', 'available'),
            'created_by' => Auth::id(),
        ]);

        // Add features if provided
        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                $property->features()->create([
                    'key' => $feature['key'],
                    'value' => $feature['value']
                ]);
            }
        }

        $property->load(['propertyType', 'creator', 'features']);

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully',
            'data' => $property
        ], 201);
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property): JsonResponse
    {
        $property->load(['propertyType', 'creator', 'images', 'features', 'transactions.user']);

        return response()->json([
            'success' => true,
            'data' => $property
        ]);
    }

    /**
     * Update the specified property.
     */
    public function update(PropertyRequest $request, Property $property): JsonResponse
    {


        // Update features if provided
        if ($request->has('features')) {
            $property->features()->delete();
            foreach ($request->features as $feature) {
                $property->features()->create([
                    'key' => $feature['key'],
                    'value' => $feature['value']
                ]);
            }
        }

        $property->load(['propertyType', 'creator', 'features']);

        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully',
            'data' => $property
        ]);
    }

    /**
     * Remove the specified property.
     */
    public function destroy(Property $property): JsonResponse
    {

        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully'
        ]);
    }

    /**
     * Get properties by user.
     */
    public function myProperties(): JsonResponse
    {
        $properties = Property::with(['propertyType', 'images', 'features'])
            ->where('created_by', Auth::id())
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $properties
        ]);
    }
}
