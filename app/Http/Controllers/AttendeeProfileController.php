<?php

namespace App\Http\Controllers;

use App\Models\AttendeeProfile;
use Illuminate\Http\Request;

class AttendeeProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = AttendeeProfile::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Attendee profile fetched successfully',
            'data' => $profile,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'interests' => 'required|array|min:1',
            'interests.*' => 'string',

            'preferred_event_format' => 'required|in:physical,online,hybrid,no_preference',

            'event_goals' => 'required|array|min:1',
            'event_goals.*' => 'string',

            'average_spend_range' => 'required|in:free_only,under_5k,5k_20k,20k_50k,50k_plus',

            'physical_events_attended_count' => 'nullable|integer|min:0',
            'online_events_attended_count' => 'nullable|integer|min:0',

            'preferred_city' => 'nullable|string|max:100',
            'preferred_state' => 'nullable|string|max:100',

            'age_range' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
        ]);

        $profile = AttendeeProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                ...$validated,
                'profile_completed' => true,
                'completed_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'Attendee profile updated successfully',
            'data' => $profile,
        ]);
    }

    public function options()
    {
        return response()->json([
            'message' => 'Attendee onboarding options fetched successfully',
            'data' => [
                'event_formats' => [
                    ['label' => 'Physical events', 'value' => 'physical'],
                    ['label' => 'Online events', 'value' => 'online'],
                    ['label' => 'Hybrid events', 'value' => 'hybrid'],
                    ['label' => 'No preference', 'value' => 'no_preference'],
                ],

                'event_goals' => [
                    ['label' => 'Entertainment', 'value' => 'entertainment'],
                    ['label' => 'Learning / Education', 'value' => 'education'],
                    ['label' => 'Networking / Meetups', 'value' => 'networking'],
                    ['label' => 'Business Growth', 'value' => 'business_growth'],
                    ['label' => 'Community', 'value' => 'community'],
                    ['label' => 'Faith / Religious', 'value' => 'faith'],
                    ['label' => 'Wellness', 'value' => 'wellness'],
                ],

                'spend_ranges' => [
                    ['label' => 'Free events only', 'value' => 'free_only'],
                    ['label' => 'Under ₦5,000', 'value' => 'under_5k'],
                    ['label' => '₦5,000 - ₦20,000', 'value' => '5k_20k'],
                    ['label' => '₦20,000 - ₦50,000', 'value' => '20k_50k'],
                    ['label' => '₦50,000+', 'value' => '50k_plus'],
                ],

                'age_ranges' => [
                    ['label' => 'Under 18', 'value' => 'under_18'],
                    ['label' => '18 - 24', 'value' => '18_24'],
                    ['label' => '25 - 34', 'value' => '25_34'],
                    ['label' => '35 - 44', 'value' => '35_44'],
                    ['label' => '45+', 'value' => '45_plus'],
                ],
            ],
        ]);
    }
}
