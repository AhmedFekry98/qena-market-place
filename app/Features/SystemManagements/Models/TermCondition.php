<?php

namespace App\Features\SystemManagements\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];
}
