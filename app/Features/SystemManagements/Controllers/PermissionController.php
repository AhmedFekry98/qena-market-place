<?php

namespace App\Features\SystemManagements\Controllers;

use App\Features\SystemManagements\Models\Permission;
use App\Features\SystemManagements\Requests\PermissionRequest;
use App\Features\SystemManagements\Transformers\PermissionCollection;
use App\Features\SystemManagements\Transformers\PermissionResource;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;

class PermissionController extends Controller
{
    use ApiResponses;
    private static $model = Permission::class;



    /**
        * Display a listing of the resource.
        */
        public function index()
        {
            $paginate = request("page");
            $search = request("search");
            $query = self::$model::query();

            if ($search) {
                $query->where("name", "like", "%{$search}%")
                ->orWhere("caption", "like", "%{$search}%")
                ->orWhere("group", "like", "%{$search}%");
            }


            $result = $paginate ? $query->paginate(config("paginate.count")) : $query->get();

            if (is_string($result)) {
                return $this->badResponse(
                    message: $result
                );
            }


            return $this->okResponse(
                $paginate ?
                PermissionCollection::make($result) :
                PermissionResource::collection($result),
                "Success api call"
            );
        }

        /**
            * Store a newly created resource in storage.
            */
        public function store(PermissionRequest $request)
        {

            $result = self::$model::create($request->validated());

            if (is_string($result)) {
                return $this->badResponse(
                    message: $result
                );
            }

            return $this->okResponse(
                PermissionResource::make($result),
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
                PermissionResource::make($result),
                "Success api call"
            );
        }

        /**
            * Update the specified resource in storage.
            */
        public function update(PermissionRequest $request, string $id)
        {
            $result = self::$model::find($id);

            if (is_string($result)) {
                return $this->badResponse(
                    message: $result
                );
            }

            $result->update($request->validated());

            return $this->okResponse(
                PermissionResource::make($result),
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
                PermissionResource::make($result),
                "Success api call"
            );
        }
}
