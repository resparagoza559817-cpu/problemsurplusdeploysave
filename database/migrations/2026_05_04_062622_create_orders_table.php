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
    Schema::create('orders', function (Blueprint $col) {
        $col->id();
        $col->string('customer_name');
        $col->text('customer_address')->nullable();
        $col->decimal('total_amount', 10, 2);
        $col->string('payment_method'); // Cash or GCash (replacing Delivery)
        $col->timestamps();
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
