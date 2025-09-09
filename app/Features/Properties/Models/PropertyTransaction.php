<?php

namespace App\Features\Properties\Models;

use App\Features\SystemManagements\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'type',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the property that owns the transaction.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user (client) who made the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include rental transactions.
     */
    public function scopeRentals($query)
    {
        return $query->where('type', 'rent');
    }

    /**
     * Scope a query to only include sale transactions.
     */
    public function scopeSales($query)
    {
        return $query->where('type', 'sale');
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
