<?php

namespace App\Models;

use App\Traits\HasDates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory, HasDates;

    public const STATUS_NEW = 'new';
    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_SAVED = 'saved';

    protected $fillable = [
        'uuid',
        'ticket_type',
        'other_type_text',
        'details',
        'employee_name',
        'department_id',
        'technician_id',
        'priority',
        'status'
    ];

    protected $appends = ['display_type', 'priority_name', 'status_name', 'creation_date', 'closable'];

    protected $with = ['department', 'technician'];

    public static array $ticketStatus = [
        'new' => 'جديد',
        'assigned' => 'قيد المعالجة',
        'closed' => 'تمت المعالجة',
        'saved' => 'تم الحفظ',
    ];

    public static array $ticketPriority = [
        'normal' => 'عادي',
        'urgent' => 'عاجل',
        'super-argent' => 'طارئ',
    ];

    public static array $deviceTypes = [
        1 => 'حاسب آلي',
        2 => 'طابعة',
        3 => 'ماسح ضوئي',
        5 => 'شاشة',
        6 => 'شبكة',
        7 => 'تلفون',
        4 => 'أخرى',
    ];

    public function actions(): HasMany
    {
        return $this->hasMany(TicketAction::class);
    }

    public function finishAction()
    {
        return $this->hasOne(TicketAction::class)
            ->where('action_type_id', TicketAction::ACTION_CLOSED)
            ->latest();
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function scopeForTechnician(Builder $builder, $userId)
    {
        $builder->where('technician_id', $userId);
    }

    public function scopeStatus(Builder $builder, string $status)
    {
        $builder->where('status', $status);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['priority'] ?? null, function ($query, $priority) {
            $query->where('priority', $priority);
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when($filters['department_id'] ?? null, function ($query, $department_id) {
            $query->where('department_id', $department_id);
        })->when($filters['ticket_type'] ?? null, function ($query, $ticket_type) {
            $query->where('ticket_type', $ticket_type);
        });
    }

    public function statusName(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            return static::$ticketStatus[$attributes['status']];
        });
    }

    public function closable(): Attribute
    {
        return Attribute::get(fn ($value, $atts) => $atts['status'] === self::STATUS_ASSIGNED);
    }

    public function priorityName(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            return static::$ticketPriority[$attributes['priority']];
        });
    }

    public function displayType(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            return $attributes['other_type_text'] ?: static::$deviceTypes[$attributes['ticket_type']];
        });
    }
}
