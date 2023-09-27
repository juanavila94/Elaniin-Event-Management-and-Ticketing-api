<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'events';
    protected $fillable = [
        'event_name',
        'description',
        'start_date',
        'end_date',
        'location',
        'header_image',
        'status',
        'user_id'
    ];

    const STATUS_OPTIONS =
    [
        'drafted' => 'Drafted',
        'published' => 'Published',
    ];

    static $rules =
    [

        'event_name' => 'required', 'string', 'max:255',
        'description' => 'required', 'string', 'max:600',
        'start_date' => 'required', 'date',
        'end_date' => 'required', 'after:start_date',
        'location' => 'required', 'string', 'max:255',
        'header_image' => 'required', 'string',
        'status' => 'required', 'string',

    ];

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
