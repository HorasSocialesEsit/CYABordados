<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden asignar en masa
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'estado',
        'foto',
    ];

    /**
     * Campos que deben ocultarse en arrays/JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting de atributos
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // en Laravel 10+ esto automáticamente aplica bcrypt
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return $this->roles()->whereIn('name', $roles)->exists();
        }

        return $this->roles()->where('name', $roles)->exists();
    }

    public function hasAnyRole(array $roleNames)
    {
        return $this->roles->whereIn('name', $roleNames)->isNotEmpty();
    }
    public function isActive()
    {
        return $this->last_activity && $this->last_activity >= now()->subMinutes(5);
    }
    public function isOnline()
    {
        return $this->last_activity && Carbon::parse($this->last_activity)->gt(now()->subMinutes(5));
    }
}
