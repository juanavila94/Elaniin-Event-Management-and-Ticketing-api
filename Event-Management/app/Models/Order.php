<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory, HasUuids;

    const STATUS_OPTIONS = 
    [
        'inProgress' => 'In Progress',
        'completed' => 'Completed',
        'underReview' => 'Under Review',
        'refunded'  => 'Refunded',
        
    ];


    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function attendees(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }
}
