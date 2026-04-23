<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('category');
            $table->string('description');
            $table->decimal('amount', 14, 2);
            $table->nullableMorphs('reference');
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();

            $table->index('tenant_id');
            $table->index(['tenant_id', 'date']);
            $table->index(['tenant_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
