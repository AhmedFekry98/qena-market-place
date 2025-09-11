<?php

namespace App\Features\AuthManagement\Models;

use App\Features\SystemManagements\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoToken extends Model
{
    use HasFactory;


    protected $table = 'expo_tokens';

    protected $fillable = [
        'user_id',
        'token',
    ];

    // make user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
