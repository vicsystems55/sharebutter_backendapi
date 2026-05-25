<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'banner',
        'thumbnail',
        'event_type',
        'event_format',
        'venue_name',
        'address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'online_platform',
        'online_link',
        'online_access_code',
        'starts_at',
        'ends_at',
        'timezone',
        'visibility',
        'publish_mode',
        'waitlist_threshold',
        'waitlist_expires_at',
        'instant_publish_cost_orbs',
        'status',
        'allow_reviews',
        'allow_refunds',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'waitlist_expires_at' => 'datetime',
        'allow_reviews' => 'boolean',
        'allow_refunds' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(EventTicketType::class);
    }
}
