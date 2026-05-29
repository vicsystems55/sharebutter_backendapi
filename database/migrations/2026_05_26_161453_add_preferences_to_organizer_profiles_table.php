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
        Schema::table('organizer_profiles', function (Blueprint $table) {
            $table->json('event_categories')->nullable()->after('bio');
            $table->enum('preferred_event_format', [
                'physical',
                'online',
                'hybrid',
                'no_preference',
            ])->default('physical')->after('event_categories');

            $table->string('event_frequency')->nullable()->after('preferred_event_format');
            $table->string('target_audience')->nullable()->after('event_frequency');
            $table->unsignedBigInteger('average_ticket_price_orbs')->nullable()->after('target_audience');
            $table->unsignedInteger('typical_capacity')->nullable()->after('average_ticket_price_orbs');
            $table->json('states_operated_in')->nullable()->after('typical_capacity');
            $table->string('organizer_goal')->nullable()->after('states_operated_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizer_profiles', function (Blueprint $table) {
            //
        });
    }
};
