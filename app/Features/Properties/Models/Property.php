<?php

namespace App\Features\Properties\Models;

use App\Features\SystemManagements\Models\User;
use App\Features\Regions\Models\City;
use App\Features\Regions\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'property_type_id',
        'agent_id',
        'title',
        'description',
        'address',
        'area_id',
        'city_id',
        'price',
        'listing_type',
        'status',
        'created_by',
        'marketer_id',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the property type that owns the property.
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the user that created the property.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the city that owns the property.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the area that owns the property.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get all features for this property.
     */
    public function features(): HasMany
    {
        return $this->hasMany(PropertyFeature::class);
    }

    /**
     * Scope a query to only include available properties.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include properties in a specific city.
     */
    public function scopeInCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    /**
     * Scope a query to only include properties in a specific area.
     */
    public function scopeInArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    /**
     * Scope a query to filter by property type.
     */
    public function scopeOfType($query, $propertyTypeId)
    {
        return $query->where('property_type_id', $propertyTypeId);
    }

    /**
     * Scope a query to filter by price range.
     */
    public function scopePriceBetween($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Register media collections for property images.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
            ->useDisk('public'); // Store in public disk
    }


    /**
     * Register media conversions for property images.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->sharpen(10);
    }

    /**
     * Get all property images from media library.
     */
    public function getPropertyImages()
    {
        return $this->getMedia('images');
    }

    /**
     * Get primary property image from media library.
     */
    public function getPrimaryImage()
    {
        return $this->getFirstMedia('primary_image');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Scope to get properties where user is the agent
     */
    public function scopeWhereAgent($query, $agentId)
    {
        return $query->where('agent_id', $agentId);
    }
}
