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
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIPS
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('wallet_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | VALUE
            |--------------------------------------------------------------------------
            */
            $table->unsignedBigInteger('amount_orbs');

            // payout snapshot
            $table->decimal('amount_currency', 18, 2);
            $table->string('currency', 3)->default('NGN');
            $table->decimal('exchange_rate', 18, 6)->nullable();

            /*
            |--------------------------------------------------------------------------
            | FEES
            |--------------------------------------------------------------------------
            */
            $table->decimal('processing_fee', 18, 2)->default(0);
            $table->decimal('net_amount', 18, 2);

            /*
            |--------------------------------------------------------------------------
            | BANK DETAILS SNAPSHOT
            |--------------------------------------------------------------------------
            */
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');

            /*
            |--------------------------------------------------------------------------
            | REFERENCES
            |--------------------------------------------------------------------------
            */
            $table->string('reference')->unique();
            $table->string('gateway_reference')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'pending',
                'approved',
                'processing',
                'paid',
                'failed',
                'rejected',
                'cancelled',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | ADMIN WORKFLOW
            |--------------------------------------------------------------------------
            */
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->text('admin_note')->nullable();
            $table->text('failure_reason')->nullable();

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
            $table->index(['user_id', 'status']);
            $table->index(['wallet_id']);
            $table->index(['status']);
            $table->index(['reference']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_requests');
    }
};
