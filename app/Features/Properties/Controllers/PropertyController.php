<?php

namespace App\Features\Properties\Controllers;

use App\Features\Properties\Models\Property;
use App\Features\Properties\Requests\PropertyRequest;
use App\Features\Properties\Transformers\PropertyCollection;
use App\Features\Properties\Transformers\PropertyResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of properties.
     */
    public function index(Request $request): JsonResponse
    {
        $role = auth()->user()->role;
        if ($role !== 'admin') {
            $query = Property::query()->where('is_active', true);
        } else {
            $query = Property::query();
        }

        // Filter by property type
        if ($request->has('property_type_id')) {
            $query->ofType($request->property_type_id);
        }

        // Filter by city
        if ($request->has('city_id')) {
            $query->inCity($request->city_id);
        }

        // Filter by area
        if ($request->has('area_id')) {
            $query->inArea($request->area_id);
        }

        // Filter by listing type
        if ($request->has('listing_type')) {
            $query->where('listing_type', $request->listing_type);
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

        return $this->okResponse(PropertyCollection::make($properties), "Success api call");
    }

    /**
     * Store a newly created property.
     */
    public function store(PropertyRequest $request): JsonResponse
    {

        $property = Property::create([
            'property_type_id' => $request->property_type_id,
            'agent_id' => $request->agent_id,
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'area_id' => $request->area_id,
            'price' => $request->price,
            'listing_type' => $request->listing_type,
            'status' => $request->status ?? 'available',
            'is_active' => $request->is_active ?? true,
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
        // add images if provided
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $property->addMedia($image)->toMediaCollection('images');
            }
        }

        return $this->okResponse(PropertyResource::make($property), "Property created successfully");
    }

    /**
     * Display the specified property.
     */
    public function show($id): JsonResponse
    {
        $property = Property::findOrFail($id);
        return $this->okResponse(PropertyResource::make($property), "Property retrieved successfully");
    }

    /**
     * Update the specified property.
     */
    public function update(PropertyRequest $request, $id): JsonResponse
    {
        $property = Property::findOrFail($id);

        // Update property fields
        $property->update([
            'property_type_id' => $request->property_type_id ?? $property->property_type_id,
            'agent_id' => $request->agent_id ?? $property->agent_id,
            'title' => $request->title ?? $property->title,
            'description' => $request->description ?? $property->description,
            'address' => $request->address ?? $property->address,
            'city_id' => $request->city_id ?? $property->city_id,
            'area_id' => $request->area_id ?? $property->area_id,
            'price' => $request->price ?? $property->price,
            'listing_type' => $request->listing_type ?? $property->listing_type,
            'status' => $request->status ?? $property->status,
            'is_active' => $request->is_active ?? $property->is_active,
        ]);

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

        // Update images if provided
        if ($request->has('images')) {
            $property->images()->delete();
            foreach ($request->images as $image) {
                $property->addMedia($image)->toMediaCollection('images');
            }
        }

        return $this->okResponse(PropertyResource::make($property), "Property updated successfully");

    }

    /**
     * Remove the specified property.
     */
    public function destroy($id): JsonResponse
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return $this->okResponse(null, "Property deleted successfully");
    }

    /**
     * Change the status of a property
     */
    public function changeStatus($id): JsonResponse
    {
        $property = Property::find($id);

        if (!$property) {
            return $this->badResponse(
                message: "Property not found"
            );
        }

        // Toggle the status
        $property->is_active = !$property->is_active;
        $property->save();

        return $this->okResponse(
            PropertyResource::make($property),
            "Property status changed successfully"
        );
    }
}
