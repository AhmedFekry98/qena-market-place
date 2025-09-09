<?php

namespace App\Features\Properties\Controllers;

use App\Features\Properties\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PropertyImageController extends Controller
{
    /**
     * Store property images using media library.
     */
    public function store(Request $request, Property $property): JsonResponse
    {
        // Check if user owns this property
        if ($property->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to add images to this property'
            ], 403);
        }

        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_primary' => 'sometimes|boolean'
        ]);

        $uploadedImages = [];
        $isPrimary = $request->get('is_primary', false);

        foreach ($request->file('images') as $index => $image) {
            if ($isPrimary && $index === 0) {
                // Add as primary image (single file collection)
                $mediaItem = $property->addMediaFromRequest('images.' . $index)
                    ->toMediaCollection('primary_image');
            } else {
                // Add to regular images collection
                $mediaItem = $property->addMediaFromRequest('images.' . $index)
                    ->toMediaCollection('images');
            }

            $uploadedImages[] = [
                'id' => $mediaItem->id,
                'url' => $mediaItem->getUrl(),
                'thumb_url' => $mediaItem->getUrl('thumb'),
                'preview_url' => $mediaItem->getUrl('preview'),
                'name' => $mediaItem->name,
                'collection' => $mediaItem->collection_name,
                'is_primary' => $mediaItem->collection_name === 'primary_image'
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully',
            'data' => $uploadedImages
        ], 201);
    }

    /**
     * Delete a property image from media library.
     */
    public function destroy(Request $request, Property $property, $mediaId): JsonResponse
    {
        // Check if user owns the property
        if ($property->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this image'
            ], 403);
        }

        $mediaItem = $property->getMedia()->where('id', $mediaId)->first();

        if (!$mediaItem) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ], 404);
        }

        $mediaItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    /**
     * Set an image as primary using media library.
     */
    public function setPrimary(Request $request, Property $property, $mediaId): JsonResponse
    {
        // Check if user owns the property
        if ($property->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this image'
            ], 403);
        }

        $mediaItem = $property->getMedia('images')->where('id', $mediaId)->first();

        if (!$mediaItem) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ], 404);
        }

        // Move the image to primary collection
        $mediaItem->move($property, 'primary_image');

        return response()->json([
            'success' => true,
            'message' => 'Image set as primary successfully',
            'data' => [
                'id' => $mediaItem->id,
                'url' => $mediaItem->getUrl(),
                'thumb_url' => $mediaItem->getUrl('thumb'),
                'preview_url' => $mediaItem->getUrl('preview'),
                'name' => $mediaItem->name,
                'collection' => 'primary_image',
                'is_primary' => true
            ]
        ]);
    }

    /**
     * Get all images for a property.
     */
    public function index(Property $property): JsonResponse
    {
        $images = $property->getMedia()->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'thumb_url' => $media->getUrl('thumb'),
                'preview_url' => $media->getUrl('preview'),
                'name' => $media->name,
                'collection' => $media->collection_name,
                'is_primary' => $media->collection_name === 'primary_image'
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }
}
