<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Billable;

class Attendee extends Model
{
    use HasFactory, HasUuids, Billable;
    
    protected $table = 'attendees';
    protected $guarded = [];

    public function orders(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
