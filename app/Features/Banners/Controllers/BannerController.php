<?php

namespace App\Features\Banners\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Features\Banners\Models\Banner;
use App\Features\Banners\Transformers\BannerCollection;
use App\Features\Banners\Transformers\BannerResource;

class BannerController extends Controller
{
    use ApiResponses;


    /**
        * Inject your service in constructor
        */
    public function __construct() {}

    /**
        * Display a listing of the resource.
        */
    public function index()
    {
        $role = auth()->user()->role;
        if ($role !== 'admin') {
            $result = Banner::where('is_active', true)->get();
        } else {
            $result = Banner::all();
        }


        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            BannerResource::collection($result),
            "Success api call"
        );
    }

    /**
        * Store a newly created resource in storage.
        */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $result = Banner::create($validator);

        // add image to banner
        $result->addMediaFromRequest('image')->toMediaCollection('banners');

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            BannerResource::make($result),
            "Success api call"
        );
    }

    /**
        * Display the specified resource.
        */
    public function show(string $id)
    {
        $result = Banner::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        return $this->okResponse(
            BannerResource::make($result),
            "Success api call"
        );
    }

    /**
        * Update the specified resource in storage.
        */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'title' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $result = Banner::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        $result->update($validator);
        // update image
        if ($request->hasFile('image')) {
            $result->clearMediaCollection('banners');
            $result->addMediaFromRequest('image')->toMediaCollection('banners');
        }

        return $this->okResponse(
            BannerResource::make($result),
            "Success api call"
        );
    }

    /**
        * Remove the specified resource from storage.
        */
    public function destroy(string $id)
    {
        $result = Banner::find($id);

        if (is_string($result)) {
            return $this->badResponse(
                message: $result
            );
        }

        $result->delete();

        return $this->okResponse(
            BannerResource::make($result),
            "Success api call"
        );
    }

    /**
     * Change the status of a banner
     */
    public function changeStatus(string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return $this->badResponse(
                message: "Banner not found"
            );
        }

        // Toggle the status
        $banner->is_active = !$banner->is_active;
        $banner->save();

        return $this->okResponse(
            BannerResource::make($banner),
            "Banner status changed successfully"
        );
    }
}
