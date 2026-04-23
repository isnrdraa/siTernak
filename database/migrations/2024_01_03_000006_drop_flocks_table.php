<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('flocks');
    }

    public function down(): void
    {
        Schema::create('flocks', function ($table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cage_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('breed')->nullable();
            $table->unsignedInteger('initial_quantity')->default(0);
            $table->unsignedInteger('current_quantity')->default(0);
            $table->unsignedInteger('age_weeks')->default(0);
            $table->date('entry_date');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->index('tenant_id');
            $table->index('cage_id');
        });
    }
};
