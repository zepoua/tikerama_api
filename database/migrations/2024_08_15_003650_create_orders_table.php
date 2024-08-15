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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_number', 50)->unique();
            $table->foreignId('order_event_id')->constrained('events', 'event_id')->onDelete('cascade');
            $table->mediumInteger('order_price');
            $table->string('order_type', 50);
            $table->string('order_payment', 100);
            $table->text('order_info')->nullable();
            $table->timestamp('order_created_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
