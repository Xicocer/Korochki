<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'login', 'full_name', 'phone', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin(): bool
    {
        return $this->login === 'Admin' || $this->role === 'admin';
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
