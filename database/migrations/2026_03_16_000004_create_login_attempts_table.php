<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('email_tente')->nullable()->index();
            $table->timestamp('attempt_time')->index();
            $table->string('status', 20)->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
};