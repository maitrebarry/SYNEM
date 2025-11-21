<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contact_faqs', function (Blueprint $table) {
            $table->string('link')->nullable()->after('answer');
            $table->enum('link_type', ['internal', 'external', 'modal'])->default('internal')->after('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_faqs', function (Blueprint $table) {
            $table->dropColumn(['link', 'link_type']);
        });
    }
};
