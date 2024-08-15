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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->foreignId('ticket_event_id')->constrained('events', 'event_id')->onDelete('cascade');
            $table->string('ticket_email', 255);
            $table->string('ticket_phone', 20);
            $table->mediumInteger('ticket_price');
            $table->foreignId('ticket_order_id')->constrained('orders', 'order_id')->onDelete('cascade');
            $table->string('ticket_key', 100)->unique();
            $table->foreignId('ticket_ticket_type_id')->constrained('ticket_types', 'ticket_type_id')->onDelete('cascade');
            $table->enum('ticket_status', ['active', 'validated', 'expired', 'cancelled']);
            $table->timestamp('ticket_created_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
