<?php

namespace App\Features\Regions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'name_ar',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the city that owns the area.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Scope a query to only include active areas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get all properties in this area.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(\App\Features\Properties\Models\Property::class);
    }

    /**
     * Scope a query to filter by city.
     */
    public function scopeInCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }
}
