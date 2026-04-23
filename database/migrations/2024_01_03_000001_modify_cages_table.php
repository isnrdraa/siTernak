<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cages', function (Blueprint $table) {
            $table->string('location')->nullable()->after('name');
            $table->unsignedInteger('current_count')->default(0)->after('capacity');
            $table->dropUnique(['tenant_id', 'code']);
            $table->dropColumn('code');
        });
    }

    public function down(): void
    {
        Schema::table('cages', function (Blueprint $table) {
            $table->string('code')->after('name');
            $table->dropColumn(['location', 'current_count']);
            $table->unique(['tenant_id', 'code']);
        });
    }
};
