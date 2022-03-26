<?php

namespace App\Models;

use App\Traits\HasDates;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAction extends Model
{
    use HasFactory, HasDates;

    protected $guarded = [];

    public const ACTION_CREATED = 'create';

    public const ACTION_ASSIGNED = 'assign';

    public const ACTION_CLOSED = 'close';

    public const ACTION_SAVED = 'save';

    public static array $actionTypes = [
        self::ACTION_CREATED => 'إنشاء',
        self::ACTION_ASSIGNED => 'إسناد للفني',
        self::ACTION_CLOSED => 'إنهاء الطلب',
        self::ACTION_SAVED => 'حفظ الطلب'
    ];

    protected $with = ['creator'];

    protected $appends = ['action_name', 'creator_name', 'creation_date'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actionName(): Attribute
    {
        return Attribute::get(fn ($value, $attrs) => self::$actionTypes[$this->action_type_id]);
    }

    public function creatorName(): Attribute
    {
        return Attribute::get(fn () => $this->creator->name);
    }
}
