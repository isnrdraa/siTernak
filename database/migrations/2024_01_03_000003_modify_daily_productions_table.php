<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_productions', function (Blueprint $table) {
            $table->dropUnique('daily_prod_unique');
            $table->dropConstrainedForeignId('flock_id');
            $table->dropColumn(['eggs_count', 'broken_count']);
        });

        Schema::table('daily_productions', function (Blueprint $table) {
            $table->foreignId('product_id')->after('cage_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 12, 2)->default(0)->after('date');
            $table->decimal('damaged_count', 12, 2)->default(0)->after('quantity');
            $table->unique(['tenant_id', 'cage_id', 'product_id', 'date'], 'daily_prod_unique');
        });
    }

    public function down(): void
    {
        Schema::table('daily_productions', function (Blueprint $table) {
            $table->dropUnique('daily_prod_unique');
            $table->dropConstrainedForeignId('product_id');
            $table->dropColumn(['quantity', 'damaged_count']);
        });

        Schema::table('daily_productions', function (Blueprint $table) {
            $table->foreignId('flock_id')->after('cage_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('eggs_count')->default(0);
            $table->unsignedInteger('broken_count')->default(0);
            $table->unique(['tenant_id', 'cage_id', 'flock_id', 'date'], 'daily_prod_unique');
        });
    }
};
