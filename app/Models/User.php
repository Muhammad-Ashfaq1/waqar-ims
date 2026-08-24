<?php

namespace App\Models;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'profile_image',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function getProfileImageUrlAttribute(): string
    {
        if ($this->profile_image && Storage::disk('public')->exists($this->profile_image)) {
            return Storage::url($this->profile_image);
        }

        return asset('img/img.jpg');
    }

    public function getRoleLabelAttribute(): string
    {
        return UserRole::labelFor($this->roles->first()?->name);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(UserRole::SuperAdmin->value);
    }

    public function isInventoryManager(): bool
    {
        return $this->hasRole(UserRole::InventoryManager->value);
    }

    public function isEmployee(): bool
    {
        return $this->hasRole(UserRole::Employee->value);
    }

    public function canManageBaseData(): bool
    {
        return $this->is_active && $this->can(UserPermission::BaseDataManage->value);
    }

    public function canManageUsers(): bool
    {
        return $this->is_active && $this->can(UserPermission::UsersManage->value);
    }

    public function canManageInventory(): bool
    {
        return $this->is_active && $this->can(UserPermission::InventoryManage->value);
    }
}
