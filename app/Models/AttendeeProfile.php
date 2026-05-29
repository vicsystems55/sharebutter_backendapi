<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendeeProfile extends Model
{
    protected $fillable = [
        'user_id',
        'interests',
        'preferred_event_format',
        'event_goals',
        'average_spend_range',
        'physical_events_attended_count',
        'online_events_attended_count',
        'preferred_city',
        'preferred_state',
        'age_range',
        'occupation',
        'profile_completed',
        'completed_at',
    ];

    protected $casts = [
        'interests' => 'array',
        'event_goals' => 'array',
        'profile_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
