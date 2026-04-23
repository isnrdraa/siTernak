<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('flock_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->unsignedInteger('eggs_count')->default(0);
            $table->unsignedInteger('broken_count')->default(0);
            $table->foreignId('recorded_by')->constrained('users');
            $table->foreignId('validated_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('tenant_id');
            $table->index(['tenant_id', 'date']);
            $table->unique(['tenant_id', 'cage_id', 'flock_id', 'date'], 'daily_prod_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_productions');
    }
};
