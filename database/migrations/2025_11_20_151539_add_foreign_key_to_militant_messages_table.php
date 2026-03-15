<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('militant_messages') || !Schema::hasTable('militants')) {
            return;
        }

        Schema::table('militant_messages', function (Blueprint $table) {
            $table->foreign('militant_id')
                ->references('id')
                ->on('militants')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('militant_messages')) {
            return;
        }

        Schema::table('militant_messages', function (Blueprint $table) {
            $table->dropForeign(['militant_id']);
        });
    }
};