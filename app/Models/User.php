<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active' // Keep 'role' if you intend to store it for other purposes, but it won't affect access.
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function installations()
    {
        return $this->hasMany(Installation::class, 'technician_id');
    }

    // Removed role-specific methods as they are no longer needed for access control:
    // public function isAdmin() { return $this->role === 'admin'; }
    // public function isManager() { return $this->role === 'manager'; }
    // public function isTechnician() { return $this->role === 'technician'; }
}
