<?php

namespace App\Features\Regions\Controllers;

use App\Features\Regions\Models\Area;
use App\Features\Regions\Transformers\AreaCollection;
use App\Features\Regions\Transformers\AreaResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AreaController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of areas.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Area::with('city');

        // Filter by city
        if ($request->has('city_id')) {
            $query->inCity($request->city_id);
        }

        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        } else {
            $query->active(); // Default to active areas
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

        $areas = $query->paginate($request->get('per_page', 15));

        return $this->okResponse(AreaCollection::make($areas), "Areas retrieved successfully");
    }

    /**
     * Store a newly created area.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255|unique:areas,name',
            'name_ar' => 'required|string|max:255|unique:areas,name_ar',
            'code' => 'required|string|max:10|unique:areas,code',
        ]);

        $area = Area::create($request->only(['city_id', 'name', 'name_ar', 'code']));
        $area->load('city');

        return $this->okResponse(AreaResource::make($area), "Area created successfully");
    }

    /**
     * Display the specified area.
     */
    public function show($id): JsonResponse
    {
        $area = Area::findOrFail($id);
        return $this->okResponse(AreaResource::make($area), "Area retrieved successfully");
    }

    /**
     * Update the specified area.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $area = Area::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:areas,name,' . $area->id,
            'name_ar' => 'sometimes|string|max:255|unique:areas,name_ar,' . $area->id,
            'code' => 'sometimes|string|max:10|unique:areas,code,' . $area->id,
        ]);

        $area->update($request->only(['name', 'name_ar', 'code']));
        $area->load('city');

        return $this->okResponse(AreaResource::make($area), "Area updated successfully");
    }

    /**
     * Remove the specified area.
     */
    public function destroy($id): JsonResponse
    {
        $area = Area::findOrFail($id);
        $area->delete();
        return $this->okResponse(null, "Area deleted successfully");
    }
}
