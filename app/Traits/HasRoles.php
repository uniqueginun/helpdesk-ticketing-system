<?php

namespace App\Traits;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
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

    public function hasAnyRole(array $roles): bool
    {
        return $this->user_role === self::ROLE_ADMIN || in_array($this->user_role, $roles);
    }

    public function scopeTechnician(Builder $builder): Builder
    {
        return $builder->where('user_role', self::ROLE_TECHNICIAN);
    }

    public function canAcceptTicket(): bool
    {
        return $this->tickets()->status(Ticket::STATUS_ASSIGNED)->count() < static::MAX_TICKET_COUNT;
    }
}
