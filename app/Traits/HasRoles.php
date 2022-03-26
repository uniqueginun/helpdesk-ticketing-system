<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasRoles
{

    public static array $userTypes = [
        self::ROLE_ADMIN => 'مدير نظام',
        self::ROLE_MODERATOR => 'مشرف طلبات',
        self::ROLE_TECHNICIAN => 'فني'
    ];

    public function roleName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['user_role']
        );
    }

    public function hasRole(string $roleName): bool
    {
        return $this->user_role === $roleName;
    }
}
