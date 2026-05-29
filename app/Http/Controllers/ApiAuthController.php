<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiAuthController extends Controller
{
    // Register a new user
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'intent' => 'nullable|in:attendee,organizer,vendor',
    ]);

    $intent = $request->intent ?? 'attendee';

    $user = User::create([
        'name' => ucwords(strtolower($request->name)),
        'email' => strtolower($request->email),
        'password' => Hash::make($request->password),
    ]);

    // Everyone starts as attendee
    $user->assignRole('attendee');

    // // Optional: prepare empty organizer profile if intent is organizer
    // if ($intent === 'organizer') {
    //     \App\Models\OrganizerProfile::firstOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'approval_status' => 'draft',
    //             'subscription_status' => 'none',
    //             'country' => 'Nigeria',
    //         ]
    //     );
    // }

    \App\Jobs\SendWelcomeMail::dispatch($user, $intent);

    $token = $user->createToken('auth_token')->plainTextToken;

    $nextStep = match ($intent) {
        'organizer' => '/dashboard/organizer-onboarding',
        'vendor' => '/dashboard/vendor-onboarding',
        default => '/dashboard/attendee-onboarding',
    };

    return response()->json([
        'message' => 'User registered successfully',
        'token' => $token,
        'token_type' => 'Bearer',
        'next_step' => $nextStep,
        'intent' => $intent,
        'onboarding_required' => true,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
        ],
    ], 201);
}

    // Login user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'message' => 'Your account is not active. Please contact support.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->update([
            'last_login_at' => now(),
        ]);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'next_step' => '/dashboard',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? null,
                'avatar' => $user->avatar ?? null,
                'status' => $user->status ?? 'active',
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
        ]);
    }

    // Forgot password (send OTP)
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        // Simulate sending OTP
        $otp = rand(100000, 999999);
        // Store OTP in session or DB (for demo, return in response)
        return response()->json(['message' => 'OTP sent', 'otp' => $otp]);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);
        // Simulate OTP verification
        // In real app, check OTP from DB/session
        return response()->json(['message' => 'OTP verified']);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
