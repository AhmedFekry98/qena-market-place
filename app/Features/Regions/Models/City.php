<?php

namespace App\Features\Regions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all areas for this city.
     */
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }

    /**
     * Get active areas for this city.
     */
    public function activeAreas(): HasMany
    {
        return $this->hasMany(Area::class)->where('is_active', true);
    }

    /**
     * Get all properties in this city.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(\App\Features\Properties\Models\Property::class);
    }

    /**
     * Scope a query to only include active cities.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
