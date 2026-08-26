<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Cadet;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'course',
        'contact',
        'status',
        'trb_no',
        'is_active',
        'profile_picture',
        'last_activity',
        'last_login_at',
        'is_online',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'last_activity' => 'datetime',
        'is_online' => 'boolean',
    ];

    public function cadet(): HasOne
    {
        return $this->hasOne(Cadet::class, 'user_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    // ADMIN ONLY
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // DEAN ONLY
    public function isDean(): bool
    {
        return $this->role === 'dean';
    }

    // CADET ONLY
    public function isCadet(): bool
    {
        return $this->role === 'cadet';
    }
}