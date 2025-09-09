<?php

namespace App\Features\Regions\Controllers;

use App\Features\Regions\Models\City;
use App\Features\Regions\Transformers\CityCollection;
use App\Features\Regions\Transformers\CityResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CityController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of cities.
     */
    public function index(Request $request): JsonResponse
    {
        $query = City::query();

        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        } else {
            $query->active(); // Default to active cities
        }

        // Search by name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $cities = $query->paginate($request->get('per_page', 15));

        return $this->okResponse(CityCollection::make($cities), "Cities retrieved successfully");
    }

    /**
     * Store a newly created city.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
            'name_ar' => 'required|string|max:255|unique:cities,name_ar',
            'code' => 'required|string|max:10|unique:cities,code',
        ]);

        $city = City::create($request->only(['name', 'name_ar', 'code']));

        return $this->okResponse(CityResource::make($city), "City created successfully");
    }

    /**
     * Display the specified city.
     */
    public function show($id): JsonResponse
    {
        $city = City::findOrFail($id);
        return $this->okResponse(CityResource::make($city), "City retrieved successfully");
    }

    /**
     * Update the specified city.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $city = City::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:cities,name,' . $city->id,
            'name_ar' => 'sometimes|string|max:255|unique:cities,name_ar,' . $city->id,
            'code' => 'sometimes|string|max:10|unique:cities,code,' . $city->id,
        ]);

        $city->update($request->only(['name', 'name_ar', 'code']));

        return $this->okResponse(CityResource::make($city), "City updated successfully");
    }

    /**
     * Remove the specified city.
     */
    public function destroy($id): JsonResponse
    {
        $city = City::findOrFail($id);
        $city->delete();
        return $this->okResponse(null, "City deleted successfully");
    }

    /**
     * Get areas for a specific city.
     */
    public function areas($cityId): JsonResponse
    {
        $city = City::findOrFail($cityId);
        $areas = $city->activeAreas()->paginate(15);

        return $this->okResponse($areas, "City areas retrieved successfully");
    }
}
