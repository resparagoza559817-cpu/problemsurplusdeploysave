<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('items_json')->nullable(); // Stores the list of items
            $table->decimal('cash_tendered', 10, 2)->default(0);
            $table->decimal('change_amount', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['items_json', 'cash_tendered', 'change_amount']);
        });
    }
};