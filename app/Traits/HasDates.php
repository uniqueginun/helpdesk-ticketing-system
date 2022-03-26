<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasDates
{
    public function creationDate(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            return Carbon::parse($attributes['created_at'])->format('Y m d H:s');
        });
    }
}
