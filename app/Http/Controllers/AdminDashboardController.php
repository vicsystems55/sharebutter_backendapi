<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\OrganizerProfile;
use App\Models\PayoutRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function stats(Request $request)
    {
        $eventStatus = [
            'published' => Event::where('status', 'published')->count(),
            'draft' => Event::where('status', 'draft')->count(),
            'pending_approval' => Event::where('status', 'pending_approval')->count(),
            'completed' => Event::where('status', 'completed')->count(),
            'cancelled' => Event::where('status', 'cancelled')->count(),
            'rejected' => Event::where('status', 'rejected')->count(),
        ];

        return response()->json([
            'message' => 'Admin dashboard stats fetched successfully',
            'data' => [
                'overview' => [
                    'total_users' => User::count(),
                    'total_organizers' => OrganizerProfile::count(),
                    'total_events' => Event::count(),

                    'total_wallet_balance' => Wallet::sum('available_orbs') + Wallet::sum('locked_orbs'),
                    'orbs_in_circulation' => Wallet::sum('available_orbs') + Wallet::sum('locked_orbs'),
                    'available_orbs' => Wallet::sum('available_orbs'),
                    'locked_orbs' => Wallet::sum('locked_orbs'),
                    'total_earned_orbs' => Wallet::sum('total_earned_orbs'),
                    'total_spent_orbs' => Wallet::sum('total_spent_orbs'),
                ],

                'action_required' => [
                    'events_awaiting_approval' => Event::where('status', 'pending_approval')->count(),
                    'organizer_applications' => OrganizerProfile::where('approval_status', 'pending')->count(),
                    'flagged_events' => Event::where('status', 'suspended')->count(),
                    'suspended_accounts' => User::where('status', 'suspended')->count(),
                    'payouts_pending' => PayoutRequest::where('status', 'pending')->count(),
                ],

                'event_status' => $eventStatus,

                'top_organizers' => OrganizerProfile::with('user:id,name,email')
                    ->orderByDesc('total_tickets_sold')
                    ->limit(5)
                    ->get(),

                'top_events' => Event::with('category:id,name')
                    ->orderByDesc('tickets_sold_count')
                    ->limit(5)
                    ->get(),

                'payout_summary' => [
                    'pending_amount' => PayoutRequest::where('status', 'pending')->sum('amount_orbs'),
                    'approved_amount' => PayoutRequest::where('status', 'approved')->sum('amount_orbs'),
                    'paid_this_month' => PayoutRequest::where('status', 'paid')
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->sum('amount_orbs'),
                ],

                'recent_activity' => [
                    // Later replace with real activities/notifications
                ],

                'revenue_chart' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        [
                            'name' => 'Revenue',
                            'data' => [0, 0, 0, 0, 0, 0],
                        ],
                    ],
                ],

                'user_growth_chart' => [
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        [
                            'name' => 'Users',
                            'data' => [0, 0, 0, 0, 0, 0],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
