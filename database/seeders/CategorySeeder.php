<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            ['name' => 'Concerts & Music', 'icon' => 'music', 'color' => '#F97316'],
            ['name' => 'Parties & Nightlife', 'icon' => 'party-popper', 'color' => '#A855F7'],
            ['name' => 'Comedy Shows', 'icon' => 'laugh', 'color' => '#F59E0B'],
            ['name' => 'Festivals', 'icon' => 'sparkles', 'color' => '#EC4899'],
            ['name' => 'Food & Drink', 'icon' => 'utensils', 'color' => '#EF4444'],

            ['name' => 'Business & Networking', 'icon' => 'briefcase', 'color' => '#3B82F6'],
            ['name' => 'Conferences', 'icon' => 'presentation', 'color' => '#0EA5E9'],
            ['name' => 'Tech Events', 'icon' => 'cpu', 'color' => '#6366F1'],
            ['name' => 'Training & Workshops', 'icon' => 'graduation-cap', 'color' => '#10B981'],
            ['name' => 'Webinars', 'icon' => 'monitor-play', 'color' => '#14B8A6'],

            ['name' => 'Community Meetups', 'icon' => 'users', 'color' => '#8B5CF6'],
            ['name' => 'Religious Events', 'icon' => 'church', 'color' => '#22C55E'],
            ['name' => 'Sports Events', 'icon' => 'trophy', 'color' => '#F97316'],
            ['name' => 'Fitness & Wellness', 'icon' => 'dumbbell', 'color' => '#84CC16'],

            ['name' => 'Art & Exhibitions', 'icon' => 'palette', 'color' => '#D946EF'],
            ['name' => 'Gaming & Esports', 'icon' => 'gamepad-2', 'color' => '#8B5CF6'],
            ['name' => 'Family & Kids', 'icon' => 'baby', 'color' => '#F43F5E'],
            ['name' => 'Charity & Fundraisers', 'icon' => 'heart-handshake', 'color' => '#22C55E'],

            ['name' => 'Private Events', 'icon' => 'lock', 'color' => '#64748B'],
            ['name' => 'Weddings & Celebrations', 'icon' => 'gem', 'color' => '#FB7185'],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                    'color' => $category['color'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
