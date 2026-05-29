<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizer_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('organizer_profiles', 'event_orb_package_id')) {
                $table->foreignId('event_orb_package_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('event_orb_packages')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('organizer_profiles', 'event_categories')) {
                $table->json('event_categories')->nullable()->after('bio');
            }

            if (!Schema::hasColumn('organizer_profiles', 'preferred_event_format')) {
                $table->enum('preferred_event_format', [
                    'physical',
                    'online',
                    'hybrid',
                    'no_preference',
                ])->default('physical')->after('event_categories');
            }

            if (!Schema::hasColumn('organizer_profiles', 'event_frequency')) {
                $table->string('event_frequency')->nullable()->after('preferred_event_format');
            }

            if (!Schema::hasColumn('organizer_profiles', 'target_audience')) {
                $table->string('target_audience')->nullable()->after('event_frequency');
            }

            if (!Schema::hasColumn('organizer_profiles', 'average_ticket_price_orbs')) {
                $table->unsignedBigInteger('average_ticket_price_orbs')->nullable()->after('target_audience');
            }

            if (!Schema::hasColumn('organizer_profiles', 'typical_capacity')) {
                $table->unsignedInteger('typical_capacity')->nullable()->after('average_ticket_price_orbs');
            }

            if (!Schema::hasColumn('organizer_profiles', 'states_operated_in')) {
                $table->json('states_operated_in')->nullable()->after('typical_capacity');
            }

            if (!Schema::hasColumn('organizer_profiles', 'organizer_goal')) {
                $table->string('organizer_goal')->nullable()->after('states_operated_in');
            }

            if (!Schema::hasColumn('organizer_profiles', 'subscription_status')) {
                $table->enum('subscription_status', [
                    'none',
                    'pending_payment',
                    'active',
                    'expired',
                    'cancelled',
                ])->default('none')->after('approval_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('organizer_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('organizer_profiles', 'event_orb_package_id')) {
                $table->dropConstrainedForeignId('event_orb_package_id');
            }

            foreach ([
                'event_categories',
                'preferred_event_format',
                'event_frequency',
                'target_audience',
                'average_ticket_price_orbs',
                'typical_capacity',
                'states_operated_in',
                'organizer_goal',
                'subscription_status',
            ] as $column) {
                if (Schema::hasColumn('organizer_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
