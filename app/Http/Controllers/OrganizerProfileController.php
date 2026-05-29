<?php

namespace App\Http\Controllers;

use App\Models\OrganizerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizerProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = OrganizerProfile::with('package')
            ->where('user_id', $request->user()->id)
            ->first();

        return response()->json([
            'message' => 'Organizer profile fetched successfully',
            'data' => $profile,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_orb_package_id' => 'nullable|exists:event_orb_packages,id',

            'business_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',

            'event_categories' => 'required|array|min:1',
            'event_categories.*' => 'string',

            'preferred_event_format' => 'required|in:physical,online,hybrid,no_preference',
            'event_frequency' => 'nullable|string|max:100',
            'target_audience' => 'nullable|string|max:255',
            'average_ticket_price_orbs' => 'nullable|integer|min:0',
            'typical_capacity' => 'nullable|integer|min:0',
            'states_operated_in' => 'nullable|array',
            'states_operated_in.*' => 'string',
            'organizer_goal' => 'nullable|string|max:255',

            'business_email' => 'nullable|email|max:255',
            'business_phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',

            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',

            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',

            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',

            'bank_name' => 'nullable|string|max:100',
            'account_name' => 'nullable|string|max:150',
            'account_number' => 'nullable|string|max:20',
        ]);

        $user = $request->user();

        $existing = OrganizerProfile::where('user_id', $user->id)->first();

        $logoPath = $existing?->logo;
        $bannerPath = $existing?->banner;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('organizers/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('organizers/banners', 'public');
        }

        $slug = $existing?->slug ?? $this->generateUniqueSlug($validated['business_name']);

        $profile = OrganizerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                ...$validated,
                'slug' => $slug,
                'logo' => $logoPath,
                'banner' => $bannerPath,
                'country' => $validated['country'] ?? 'Nigeria',
                'approval_status' => 'pending',
                'subscription_status' => $validated['event_orb_package_id'] ?? null
                    ? 'pending_payment'
                    : 'none',
            ]
        );

        return response()->json([
            'message' => 'Organizer profile submitted successfully',
            'data' => $profile->load('package'),
        ], 201);
    }

    public function options()
    {
        return response()->json([
            'message' => 'Organizer onboarding options fetched successfully',
            'data' => [
                'event_formats' => [
                    ['label' => 'Physical events', 'value' => 'physical'],
                    ['label' => 'Online events', 'value' => 'online'],
                    ['label' => 'Hybrid events', 'value' => 'hybrid'],
                    ['label' => 'No preference', 'value' => 'no_preference'],
                ],

                'event_frequencies' => [
                    ['label' => 'One-time event', 'value' => 'one_time'],
                    ['label' => 'Weekly', 'value' => 'weekly'],
                    ['label' => 'Monthly', 'value' => 'monthly'],
                    ['label' => 'Quarterly', 'value' => 'quarterly'],
                    ['label' => 'Yearly', 'value' => 'yearly'],
                    ['label' => 'Occasionally', 'value' => 'occasionally'],
                ],

                'organizer_goals' => [
                    ['label' => 'Sell more tickets', 'value' => 'sell_more_tickets'],
                    ['label' => 'Build an audience', 'value' => 'build_audience'],
                    ['label' => 'Promote my brand', 'value' => 'promote_brand'],
                    ['label' => 'Manage registrations', 'value' => 'manage_registrations'],
                    ['label' => 'Get event analytics', 'value' => 'event_analytics'],
                ],

                'capacity_ranges' => [
                    ['label' => 'Under 50 people', 'value' => 50],
                    ['label' => '50 - 200 people', 'value' => 200],
                    ['label' => '200 - 500 people', 'value' => 500],
                    ['label' => '500 - 1,000 people', 'value' => 1000],
                    ['label' => '1,000+ people', 'value' => 1001],
                ],
            ],
        ]);
    }

    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (OrganizerProfile::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }


    public function adminIndex(Request $request)
    {
        $organizers = OrganizerProfile::with(['user:id,name,email', 'package'])
            ->when($request->status, fn($q, $status) => $q->where('approval_status', $status))
            ->latest()
            ->paginate(12);

        return response()->json([
            'message' => 'Organizers fetched successfully',
            'data' => $organizers,
        ]);
    }

    public function approve(OrganizerProfile $organizerProfile)
    {
        $organizerProfile->update([
            'approval_status' => 'approved',
            'is_verified' => true,
            'rejection_reason' => null,
        ]);

        $organizerProfile->user->assignRole('organizer');

        return response()->json([
            'message' => 'Organizer approved successfully',
            'data' => $organizerProfile->load('user'),
        ]);
    }

    public function reject(Request $request, OrganizerProfile $organizerProfile)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string',
        ]);

        $organizerProfile->update([
            'approval_status' => 'rejected',
            'is_verified' => false,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json([
            'message' => 'Organizer rejected successfully',
            'data' => $organizerProfile,
        ]);
    }
}
