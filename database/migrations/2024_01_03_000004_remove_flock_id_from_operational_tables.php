<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feed_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('flock_id');
        });

        Schema::table('health_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('flock_id');
        });

        Schema::table('mortality_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('flock_id');
        });
    }

    public function down(): void
    {
        Schema::table('feed_logs', function (Blueprint $table) {
            $table->foreignId('flock_id')->after('cage_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('health_logs', function (Blueprint $table) {
            $table->foreignId('flock_id')->after('cage_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('mortality_logs', function (Blueprint $table) {
            $table->foreignId('flock_id')->after('cage_id')->constrained()->cascadeOnDelete();
        });
    }
};
