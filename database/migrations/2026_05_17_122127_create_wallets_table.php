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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIP
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | BALANCES
            |--------------------------------------------------------------------------
            */

            // Available usable balance
            $table->unsignedBigInteger('available_orbs')->default(0);

            // Locked funds (pending payouts, pending settlements)
            $table->unsignedBigInteger('locked_orbs')->default(0);

            // Lifetime analytics
            $table->unsignedBigInteger('total_earned_orbs')->default(0);
            $table->unsignedBigInteger('total_spent_orbs')->default(0);

            /*
            |--------------------------------------------------------------------------
            | WALLET STATUS
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'active',
                'suspended',
                'frozen',
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | SECURITY
            |--------------------------------------------------------------------------
            */
            $table->timestamp('last_transaction_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | OPTIONAL CASHOUT SETTINGS
            |--------------------------------------------------------------------------
            */
            $table->boolean('auto_payout_enabled')->default(false);

            /*
            |--------------------------------------------------------------------------
            | METADATA
            |--------------------------------------------------------------------------
            */
            $table->json('meta')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEXES
            |--------------------------------------------------------------------------
            */
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
