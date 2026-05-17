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
        Schema::create('booking_tickets', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIPS
            |--------------------------------------------------------------------------
            */
            $table->foreignId('booking_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('event_ticket_type_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | ATTENDEE INFO
            |--------------------------------------------------------------------------
            */
            $table->string('attendee_name');
            $table->string('attendee_email');
            $table->string('attendee_phone')->nullable();

            /*
            |--------------------------------------------------------------------------
            | TICKET INFO
            |--------------------------------------------------------------------------
            */
            $table->string('ticket_code')->unique();
            $table->string('qr_code')->nullable();

            $table->unsignedBigInteger('price_orbs')->default(0);

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'reserved',
                'paid',
                'checked_in',
                'cancelled',
                'refunded',
                'expired',
                'transferred',
            ])->default('paid');

            /*
            |--------------------------------------------------------------------------
            | CHECK-IN
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_checked_in')->default(false);
            $table->timestamp('checked_in_at')->nullable();

            $table->foreignId('checked_in_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | TRANSFER SUPPORT
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_transferable')->default(false);
            $table->timestamp('transferred_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | REFUNDS
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_refunded')->default(false);
            $table->timestamp('refunded_at')->nullable();

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
            $table->index(['event_id', 'status']);
            $table->index(['attendee_email']);
            $table->index(['ticket_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_tickets');
    }
};
