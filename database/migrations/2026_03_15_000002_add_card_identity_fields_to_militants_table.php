<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('militants', function (Blueprint $table) {
            $table->string('division')->nullable()->after('coordinations');
            $table->string('region')->nullable()->after('division');
        });
    }

    public function down(): void
    {
        Schema::table('militants', function (Blueprint $table) {
            $table->dropColumn(['division', 'region']);
        });
    }
};