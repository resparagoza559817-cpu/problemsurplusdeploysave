<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('orders', 'cash_tendered')) {
                $table->decimal('cash_tendered', 10, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('orders', 'change_amount')) {
                $table->decimal('change_amount', 10, 2)->default(0)->after('cash_tendered');
            }
            if (!Schema::hasColumn('orders', 'items_json')) {
                $table->text('items_json')->after('change_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cash_tendered', 'change_amount', 'items_json']);
        });
    }
};