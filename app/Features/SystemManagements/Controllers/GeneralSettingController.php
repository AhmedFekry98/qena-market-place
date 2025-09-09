<?php

namespace App\Features\SystemManagements\Controllers;

use App\Features\SystemManagements\Models\GeneralSetting;
use App\Features\SystemManagements\Requests\GeneralSettingRequest;
use App\Features\SystemManagements\Services\GeneralSettingService;
use App\Features\SystemManagements\Transformers\GeneralSettingCollection;
use App\Features\SystemManagements\Transformers\GeneralSettingResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GeneralSettingController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $paginated = $request->boolean('page');
        $result = GeneralSettingService::getAllSettings();

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }


        return $this->okResponse(
            $paginated ? GeneralSettingCollection::make($result) : GeneralSettingResource::collection($result),
            "Settings retrieved successfully"
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GeneralSettingRequest $request)
    {
        $result = GeneralSettingService::createSetting($request->validated());

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            GeneralSettingResource::make($result),
            "Setting created successfully"
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = GeneralSettingService::getSettingById($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            GeneralSettingResource::make($result),
            "Setting retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GeneralSettingRequest $request, string $id)
    {
        $result = GeneralSettingService::updateSettingById($id, $request->validated());

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            GeneralSettingResource::make($result),
            "Setting updated successfully"
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = GeneralSettingService::deleteSettingById($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            GeneralSettingResource::make($result),
            "Setting deleted successfully"
        );
    }

    /**
     * Get setting by key
     */
    public function getByKey(string $key)
    {
        $result = GeneralSettingService::getSettingByKey($key);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            GeneralSettingResource::make($result),
            "Setting retrieved successfully"
        );
    }

    /**
     * Update or create setting by key
     */
    public function updateByKey(Request $request, string $key)
    {
        $request->validate([
            'value' => 'required|string'
        ]);

        $result = GeneralSettingService::updateOrCreateSetting($key, $request->value);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            GeneralSettingResource::make($result),
            "Setting updated successfully"
        );
    }
}
