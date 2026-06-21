<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_carousel_slides', function (Blueprint $table) {
            $table->id();
            $table->string('page', 40)->index();
            $table->string('image');
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->unsignedInteger('ordering')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_carousel_slides');
    }
};
