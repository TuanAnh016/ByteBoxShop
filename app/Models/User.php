<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable, HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        // Check the role column directly — no Spatie DB query needed
        return in_array($this->role, ['admin', 'super_admin', 'superadmin']);
    }

    protected $fillable = ['name', 'email', 'password', 'role', 'gender', 'date_of_birth'];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    protected $hidden = ['password', 'remember_token'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
