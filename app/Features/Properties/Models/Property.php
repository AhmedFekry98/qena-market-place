<?php

namespace App\Features\Properties\Models;

use App\Features\SystemManagements\Models\User;
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
        'title',
        'description',
        'address',
        'city',
        'price',
        'area',
        'status',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
    ];

    /**
     * Get the property type that owns the property.
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the user who created the property.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all features for this property.
     */
    public function features(): HasMany
    {
        return $this->hasMany(PropertyFeature::class);
    }

    /**
     * Get all images for this property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get the primary image for this property.
     */
    public function primaryImage(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->where('is_primary', true);
    }

    /**
     * Get all transactions for this property.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(PropertyTransaction::class);
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
    public function scopeInCity($query, $city)
    {
        return $query->where('city', $city);
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
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
            ->singleFile(false);

        $this->addMediaCollection('primary_image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
            ->singleFile(true);
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
}
