<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cage_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cage_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('type');
            $table->integer('quantity');
            $table->string('description')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();

            $table->index('tenant_id');
            $table->index(['cage_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cage_movements');
    }
};
