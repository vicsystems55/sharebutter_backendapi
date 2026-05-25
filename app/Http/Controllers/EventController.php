<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with(['category', 'organizer:id,name,email', 'ticketTypes'])
            ->where('status', 'published')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('venue_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('state', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category)
                        ->orWhere('name', $category);
                });
            })
            ->when($request->event_type, fn($query, $type) => $query->where('event_type', $type))
            ->when($request->event_format, fn($query, $format) => $query->where('event_format', $format))
            ->when($request->date_filter === 'today', fn($query) => $query->whereDate('starts_at', today()))
            ->when($request->date_filter === 'week', fn($query) => $query->whereBetween('starts_at', [now(), now()->addWeek()]))
            ->when($request->date_filter === 'month', fn($query) => $query->whereBetween('starts_at', [now(), now()->addMonth()]))
            ->latest('starts_at')
            ->paginate($request->per_page ?? 9);

        return response()->json([
            'message' => 'Events fetched successfully',
            'data' => $events,
        ]);
    }

    public function myEvents(Request $request)
    {
        $events = Event::with(['category', 'ticketTypes'])
            ->where('organizer_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        return response()->json([
            'message' => 'My events fetched successfully',
            'data' => $events,
        ]);
    }


    public function adminIndex(Request $request)
    {
        $events = Event::with(['category', 'organizer:id,name,email'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($request->status, fn($query, $status) => $query->where('status', $status))
            ->when($request->event_type, fn($query, $type) => $query->where('event_type', $type))
            ->when($request->event_format, fn($query, $format) => $query->where('event_format', $format))
            ->latest()
            ->paginate(12);

        return response()->json([
            'message' => 'Admin events fetched successfully',
            'data' => $events,
        ]);
    }

    public function adminShow(Event $event)
    {
        return response()->json([
            'message' => 'Event fetched successfully',
            'data' => $event->load(['category', 'organizer:id,name,email', 'ticketTypes']),
        ]);
    }

    public function certify(Event $event)
    {
        $event->update([
            'is_verified' => true,
        ]);

        return response()->json([
            'message' => 'Event certified successfully',
            'data' => $event,
        ]);
    }

    public function publish(Event $event)
    {
        $event->update([
            'status' => 'published',
        ]);

        return response()->json([
            'message' => 'Event published successfully',
            'data' => $event,
        ]);
    }

    public function reject(Request $request, Event $event)
    {
        $event->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return response()->json([
            'message' => 'Event rejected successfully',
            'data' => $event,
        ]);
    }

    public function suspend(Request $request, Event $event)
    {
        $event->update([
            'status' => 'suspended',
            'admin_note' => $request->admin_note,
        ]);

        return response()->json([
            'message' => 'Event suspended successfully',
            'data' => $event,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',

            'banner' => 'nullable|image|max:4096',
            'thumbnail' => 'nullable|image|max:2048',

            'event_type' => 'required|in:free,paid',
            'event_format' => 'required|in:physical,online,hybrid',

            'venue_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',

            'online_platform' => 'nullable|string|max:100',
            'online_link' => 'nullable|url|max:255',
            'online_access_code' => 'nullable|string|max:100',

            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'timezone' => 'nullable|string|max:100',

            'visibility' => 'required|in:public,private,invite_only',
            'publish_mode' => 'required|in:waitlist,instant',

            'allow_reviews' => 'nullable|boolean',
            'allow_refunds' => 'nullable|boolean',

            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string|max:100',
            'tickets.*.description' => 'nullable|string',
            'tickets.*.price_orbs' => 'required|integer|min:0',
            'tickets.*.quantity' => 'required|integer|min:1',
            'tickets.*.min_per_order' => 'nullable|integer|min:1',
            'tickets.*.max_per_order' => 'nullable|integer|min:1',
        ]);

        $user = $request->user();

        $event = DB::transaction(function () use ($request, $validated, $user) {
            $bannerPath = null;
            $thumbnailPath = null;

            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('events/banners', 'public');
            }

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('events/thumbnails', 'public');
            }

            $event = Event::create([
                'organizer_id' => $user->id,
                'category_id' => $validated['category_id'] ?? null,

                'title' => $validated['title'],
                'slug' => $this->generateUniqueSlug($validated['title']),
                'short_description' => $validated['short_description'] ?? null,
                'description' => $validated['description'] ?? null,

                'banner' => $bannerPath,
                'thumbnail' => $thumbnailPath,

                'event_type' => $validated['event_type'],
                'event_format' => $validated['event_format'],

                'venue_name' => $validated['venue_name'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? 'Nigeria',

                'online_platform' => $validated['online_platform'] ?? null,
                'online_link' => $validated['online_link'] ?? null,
                'online_access_code' => $validated['online_access_code'] ?? null,

                'starts_at' => $validated['starts_at'],
                'ends_at' => $validated['ends_at'] ?? null,
                'timezone' => $validated['timezone'] ?? 'Africa/Lagos',

                'visibility' => $validated['visibility'],
                'publish_mode' => $validated['publish_mode'],

                'waitlist_threshold' => 10,
                'waitlist_expires_at' => now()->addDays(14),
                'instant_publish_cost_orbs' => $validated['publish_mode'] === 'instant' ? 200 : 0,

                'status' => $validated['publish_mode'] === 'waitlist'
                    ? 'waiting_list'
                    : 'pending_approval',

                'allow_reviews' => $validated['allow_reviews'] ?? true,
                'allow_refunds' => $validated['allow_refunds'] ?? false,
            ]);

            foreach ($validated['tickets'] as $index => $ticket) {
                EventTicketType::create([
                    'event_id' => $event->id,
                    'name' => $ticket['name'],
                    'description' => $ticket['description'] ?? null,
                    'price_orbs' => $validated['event_type'] === 'free' ? 0 : $ticket['price_orbs'],
                    'quantity' => $ticket['quantity'],
                    'min_per_order' => $ticket['min_per_order'] ?? 1,
                    'max_per_order' => $ticket['max_per_order'] ?? 10,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }

            return $event->load(['category', 'ticketTypes']);
        });

        return response()->json([
            'message' => 'Event created successfully',
            'data' => $event,
        ], 201);
    }

    public function show(Event $event)
    {
        return response()->json([
            'message' => 'Event fetched successfully',
            'data' => $event->load(['category', 'organizer:id,name,email', 'ticketTypes']),
        ]);
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
