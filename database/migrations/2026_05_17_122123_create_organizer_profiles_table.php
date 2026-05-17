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
        Schema::create('organizer_profiles', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | BASIC INFO
            |--------------------------------------------------------------------------
            */
            $table->string('business_name');
            $table->string('slug')->unique();

            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();

            /*
            |--------------------------------------------------------------------------
            | CONTACT
            |--------------------------------------------------------------------------
            */
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();

            $table->string('website')->nullable();

            /*
            |--------------------------------------------------------------------------
            | LOCATION
            |--------------------------------------------------------------------------
            */
            $table->string('country')->default('Nigeria');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            /*
            |--------------------------------------------------------------------------
            | BRANDING
            |--------------------------------------------------------------------------
            */
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SOCIALS
            |--------------------------------------------------------------------------
            */
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();

            /*
            |--------------------------------------------------------------------------
            | VERIFICATION / APPROVAL
            |--------------------------------------------------------------------------
            */
            $table->enum('approval_status', [
                'pending',
                'approved',
                'rejected',
                'suspended'
            ])->default('pending');

            $table->boolean('is_verified')->default(false);

            $table->text('rejection_reason')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PAYOUT DETAILS
            |--------------------------------------------------------------------------
            */
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATS
            |--------------------------------------------------------------------------
            */
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->unsignedInteger('total_reviews')->default(0);

            $table->unsignedInteger('total_events')->default(0);
            $table->unsignedInteger('total_tickets_sold')->default(0);

            /*
            |--------------------------------------------------------------------------
            | FEATURE FLAGS
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizer_profiles');
    }
};
