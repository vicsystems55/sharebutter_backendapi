<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organizer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            $table->string('banner')->nullable();
            $table->string('thumbnail')->nullable();

            $table->enum('event_type', ['free', 'paid'])->default('free');

            // physical, online, or both
            $table->enum('event_format', ['physical', 'online', 'hybrid'])->default('physical');

            // Physical location fields
            $table->string('venue_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nigeria');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Online event fields
            $table->string('online_platform')->nullable(); // Zoom, Google Meet, YouTube, Custom
            $table->string('online_link')->nullable();
            $table->string('online_access_code')->nullable();

            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('timezone')->default('Africa/Lagos');

            $table->enum('visibility', ['public', 'private', 'invite_only'])->default('public');

            $table->enum('publish_mode', ['waitlist', 'instant'])->default('waitlist');
            $table->unsignedInteger('waitlist_threshold')->default(10);
            $table->timestamp('waitlist_expires_at')->nullable();
            $table->unsignedBigInteger('instant_publish_cost_orbs')->default(0);

            $table->enum('status', [
                'draft',
                'pending_approval',
                'waiting_list',
                'published',
                'completed',
                'cancelled',
                'expired',
                'rejected',
                'suspended',
            ])->default('draft');

            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->text('admin_note')->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('bookings_count')->default(0);
            $table->unsignedInteger('tickets_sold_count')->default(0);

            $table->boolean('allow_reviews')->default(true);
            $table->boolean('allow_refunds')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
