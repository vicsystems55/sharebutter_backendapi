<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicketType extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price_orbs',
        'display_currency',
        'quantity',
        'sold',
        'reserved',
        'min_per_order',
        'max_per_order',
        'sales_start_at',
        'sales_end_at',
        'is_active',
        'is_hidden',
        'sort_order',
    ];

    protected $casts = [
        'sales_start_at' => 'datetime',
        'sales_end_at' => 'datetime',
        'is_active' => 'boolean',
        'is_hidden' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
