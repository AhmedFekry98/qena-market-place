<?php

namespace App\Features\Properties\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'key',
        'value',
    ];

    /**
     * Get the property that owns the feature.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
