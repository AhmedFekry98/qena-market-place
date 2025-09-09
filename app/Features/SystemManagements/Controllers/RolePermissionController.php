<?php

namespace App\Features\SystemManagements\Controllers;

use App\Features\SystemManagements\Models\RolePermission;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Features\SystemManagements\Requests\AssignPermissionRequest;
use App\Features\SystemManagements\Transformers\RolePermissionResource;

class RolePermissionController extends Controller
{
    use ApiResponses;
    private static $model = RolePermission::class;

    /**
     * assign permissions to role
     */
    public function store(AssignPermissionRequest $request)
    {
        try {
            $role = self::$model::updateOrCreate([
                "role_id" => $request->role_id,
                "permission_id" => $request->permission_id,
            ], $request->validated());

            return $this->okResponse(RolePermissionResource::make($role), "Success api call");
        } catch (\Exception $th) {
            return $this->badResponse($th->getMessage());
        }
    }
}
