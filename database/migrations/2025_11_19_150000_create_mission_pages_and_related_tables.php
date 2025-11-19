<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mission_pages', function (Blueprint $table) {
            $table->id();
            $table->text('mission_main')->nullable();
            $table->string('mission_image')->nullable();
            $table->text('mission_cta')->nullable(); // JSON
            $table->timestamps();
        });

        Schema::create('mission_header_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_page_id')->constrained('mission_pages')->onDelete('cascade');
            $table->string('file');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('mission_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_page_id')->constrained('mission_pages')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('file');
            $table->timestamps();
        });

        Schema::create('mission_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_page_id')->constrained('mission_pages')->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->integer('ordering')->nullable();
            $table->timestamps();
        });

        Schema::create('mission_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_page_id')->constrained('mission_pages')->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->integer('ordering')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mission_values');
        Schema::dropIfExists('mission_items');
        Schema::dropIfExists('mission_documents');
        Schema::dropIfExists('mission_header_images');
        Schema::dropIfExists('mission_pages');
    }
};
