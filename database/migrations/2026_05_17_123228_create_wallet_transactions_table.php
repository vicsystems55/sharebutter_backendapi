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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIPS
            |--------------------------------------------------------------------------
            */
            $table->foreignId('wallet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | TRANSACTION CLASSIFICATION
            |--------------------------------------------------------------------------
            */
            $table->enum('type', [
                'credit',
                'debit',
            ]);

            $table->enum('category', [
                'wallet_topup',
                'ticket_purchase',
                'ticket_sale',
                'platform_commission',
                'instant_publish',
                'refund',
                'payout_request',
                'payout_release',
                'manual_adjustment',
                'reversal',
                'bonus',
            ]);

            /*
            |--------------------------------------------------------------------------
            | VALUE
            |--------------------------------------------------------------------------
            */
            $table->unsignedBigInteger('amount_orbs');
            $table->unsignedBigInteger('balance_before')->default(0);
            $table->unsignedBigInteger('balance_after')->default(0);

            /*
            |--------------------------------------------------------------------------
            | REFERENCE
            |--------------------------------------------------------------------------
            */
            $table->string('reference')->unique();
            $table->string('external_reference')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'pending',
                'successful',
                'failed',
                'reversed',
                'cancelled',
            ])->default('successful');

            /*
            |--------------------------------------------------------------------------
            | RELATION TO BUSINESS OBJECTS
            |--------------------------------------------------------------------------
            */
            $table->string('transactionable_type')->nullable();
            $table->unsignedBigInteger('transactionable_id')->nullable();

            $table->index(
                ['transactionable_type', 'transactionable_id'],
                'wt_txn_morph_idx'
            );

            /*
            |--------------------------------------------------------------------------
            | NARRATION
            |--------------------------------------------------------------------------
            */
            $table->string('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | OPTIONAL EXCHANGE SNAPSHOT
            |--------------------------------------------------------------------------
            */
            $table->string('currency', 3)->nullable(); // NGN, USD
            $table->decimal('exchange_rate', 18, 6)->nullable();
            $table->decimal('currency_amount', 18, 2)->nullable();

            /*
            |--------------------------------------------------------------------------
            | ADMIN
            |--------------------------------------------------------------------------
            */
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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
            $table->index(['user_id', 'type']);
            $table->index(['category']);
            $table->index(['status']);
            $table->index(['reference']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
