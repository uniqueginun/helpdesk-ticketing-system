<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'ticket_type',
        'other_type_text',
        'details',
        'demanding_unit',
        'technician_id',
        'priority',
        'status'
    ];
}
