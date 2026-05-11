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
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tracks which clerk sold it
        $table->string('customer_name')->default('Walk-in');
        $table->text('customer_address')->nullable();
        $table->decimal('total_amount', 10, 2);
        $table->decimal('cash_tendered', 10, 2)->default(0);
        $table->decimal('change_amount', 10, 2)->default(0);
        $table->text('items_json'); // Stores what was actually bought
        $table->string('payment_method');
        $table->timestamps();
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
