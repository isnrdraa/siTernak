<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('feed_type');
            $table->decimal('current_stock_kg', 12, 2)->default(0);
            $table->decimal('min_stock_kg', 12, 2)->default(0);
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'feed_type']);
            $table->index('tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_stocks');
    }
};
