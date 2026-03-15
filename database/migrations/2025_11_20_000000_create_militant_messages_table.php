<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('militant_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('militant_id');
            $table->text('question');
            $table->text('answer')->nullable();
            $table->enum('status', ['pending', 'answered'])->default('pending');
            $table->boolean('is_admin_read')->default(false);
            $table->timestamps();

            $table->index('militant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militant_messages');
    }
};
