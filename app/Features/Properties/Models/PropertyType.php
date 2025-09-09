<?php

namespace App\Features\Properties\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all properties for this property type.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
