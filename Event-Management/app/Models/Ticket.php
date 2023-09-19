<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tickets';
    protected $guarded = [];

    
    const STATUS_OPTIONS =
    [
        'checkedIn' => 'Checked in',
        'checkedOut' => 'Checked out',
        'refunded'  => 'Refunded',
        'notRefunded' => 'Not refunded',
    ];

    public function ticketTypes(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
