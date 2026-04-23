<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cage_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('breed')->nullable();
            $table->unsignedInteger('initial_quantity');
            $table->unsignedInteger('current_quantity');
            $table->unsignedInteger('age_weeks')->default(0);
            $table->date('entry_date');
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index('tenant_id');
            $table->index('cage_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flocks');
    }
};
