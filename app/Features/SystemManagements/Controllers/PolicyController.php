<?php

namespace App\Features\SystemManagements\Controllers;

use App\Features\SystemManagements\Models\Policy;
use App\Features\SystemManagements\Transformers\PolicyResource;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    use ApiResponses;

    private static $model = Policy::class;


    /**
        * Inject your service in constructor
        */
    public function __construct() {}

    /**
        * Display a listing of the resource.
        */
    public function index()
    {
        $result = self::$model::all();

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            PolicyResource::collection($result),
            "Success api call"
        );
    }

    /**
        * Store a newly created resource in storage.
        */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $result = self::$model::create($validated);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            PolicyResource::make($result),
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
            PolicyResource::make($result),
            "Success api call"
        );
    }

    /**
        * Update the specified resource in storage.
        */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $result = self::$model::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        $result->update($validated);

        return $this->okResponse(
            PolicyResource::make($result),
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
            PolicyResource::make($result),
            "Success api call"
        );
    }
}
