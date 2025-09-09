<?php

namespace App\Features\SystemManagements\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Model implements HasMedia
{
    use HasApiTokens, Notifiable, InteractsWithMedia, Authenticatable;

    protected $fillable = [
        'name',
        'phone_code',
        'phone',
        'role',
        'teacher_id',
        'teacher_code',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function role()
    {
        return $this->roles()->latest('user_roles.created_at')->first();
    }

    public function allPermissions()
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');
    }

    public function hasPermission($permissionName)
    {
        return $this->allPermissions()
            ->pluck('name')
            ->contains($permissionName);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user-image')
        ->useFallbackUrl(asset('/img/user-default.svg'))
            ->singleFile();
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'teacher_id');
    }

    public function isRole($role)
    {
        return $this->role == $role;
    }
}
