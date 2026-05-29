<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizerProfile extends Model
{



    protected $fillable = [
        'user_id',
        'event_orb_package_id',

        'business_name',
        'slug',
        'tagline',
        'bio',

        'event_categories',
        'preferred_event_format',
        'event_frequency',
        'target_audience',
        'average_ticket_price_orbs',
        'typical_capacity',
        'states_operated_in',
        'organizer_goal',

        'business_email',
        'business_phone',
        'website',

        'country',
        'state',
        'city',
        'address',

        'logo',
        'banner',

        'instagram',
        'facebook',
        'twitter',
        'linkedin',
        'tiktok',

        'approval_status',
        'is_verified',
        'rejection_reason',

        'subscription_status',
        'subscription_started_at',
        'subscription_expires_at',

        'bank_name',
        'account_name',
        'account_number',

        'rating',
        'total_reviews',
        'total_events',
        'total_tickets_sold',

        'is_featured',
    ];

    protected $casts = [
        'event_categories' => 'array',
        'states_operated_in' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'subscription_started_at' => 'datetime',
        'subscription_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(EventOrbPackage::class, 'event_orb_package_id');
    }
}
