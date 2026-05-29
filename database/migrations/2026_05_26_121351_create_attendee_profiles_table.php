<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendee_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->json('interests')->nullable();

            $table->enum('preferred_event_format', [
                'physical',
                'online',
                'hybrid',
                'no_preference',
            ])->default('no_preference');

            $table->json('event_goals')->nullable();

            $table->enum('average_spend_range', [
                'free_only',
                'under_5k',
                '5k_20k',
                '20k_50k',
                '50k_plus',
            ])->nullable();

            $table->unsignedInteger('physical_events_attended_count')->default(0);
            $table->unsignedInteger('online_events_attended_count')->default(0);

            $table->string('preferred_city')->nullable();
            $table->string('preferred_state')->nullable();

            $table->string('age_range')->nullable();
            $table->string('occupation')->nullable();

            $table->boolean('profile_completed')->default(false);
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_profiles');
    }
};
