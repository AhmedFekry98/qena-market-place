<?php

namespace App\Features\SystemManagements\Controllers;

use App\Features\SystemManagements\Models\UserRole;
use App\Features\SystemManagements\Requests\AssignRoleRequest;
use App\Features\SystemManagements\Transformers\UserRoleResource;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;

class UserRoleController extends Controller
{
    use ApiResponses;
    private static $model = UserRole::class;

    public function store(AssignRoleRequest $request)
    {
        try {
            $user = self::$model::updateOrCreate([
                "user_id" => $request->user_id,
            ], $request->validated());
            return $this->okResponse(UserRoleResource::make($user), "Success api call");
        } catch (\Exception $th) {
            return $this->badResponse($th->getMessage());
        }
    }
}
