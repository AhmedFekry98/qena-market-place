<?php

namespace App\Features\SystemManagements\Controllers;

use App\Features\SystemManagements\Models\Role;
use App\Features\SystemManagements\Requests\AssignPermissionRequest;
use App\Features\SystemManagements\Requests\RoleRequest;
use App\Features\SystemManagements\Transformers\RoleCollection;
use App\Features\SystemManagements\Transformers\RoleResource;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ApiResponses;

    private static $model = Role::class;
    /**
        * Inject your service in constructor
        */
    public function __construct() {}

    /**
        * Display a listing of the resource.
        */
    public function index()
    {
        $paginate = request("page");
        $search = request("search");
        $query = self::$model::query();

        if ($search) {
            $query->where("name", "like", "%{$search}%");
        }


        $result = $paginate ? $query->paginate(config("paginate.count")) : $query->get();

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            $paginate ?
            RoleCollection::make($result) :
            RoleResource::collection($result),
            "Success api call"
        );
    }

    /**
        * Store a newly created resource in storage.
        */
    public function store(RoleRequest $request)
    {

        $result = self::$model::create($request->validated());

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            RoleResource::make($result),
            "Success api call"
        );
    }

    /**
        * Display the specified resource.
        */
    public function show(string $id)
    {
        $result = self::$model::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            RoleResource::make($result),
            "Success api call"
        );
    }

    /**
        * Update the specified resource in storage.
        */
    public function update(RoleRequest $request, string $id)
    {
        $result = self::$model::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        $result->update($request->validated());

        return $this->okResponse(
            RoleResource::make($result),
            "Success api call"
        );
    }

    /**
        * Remove the specified resource from storage.
        */
    public function destroy(string $id)
    {
        $result = self::$model::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        $result->delete();

        return $this->okResponse(
            RoleResource::make($result),
            "Success api call"
        );
    }


}
