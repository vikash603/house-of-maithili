<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_made_to_order')->default(false)->after('status');
            $table->unsignedSmallInteger('lead_time_days')->nullable()->after('is_made_to_order');
            $table->unique('sku');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('stock');
            $table->unique('sku');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn('is_active');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn(['is_made_to_order', 'lead_time_days']);
        });
    }
};
