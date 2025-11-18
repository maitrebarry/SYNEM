<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('homepage_contents', function (Blueprint $table) {
            $table->id();
            $table->string('carousel_title')->nullable();
            $table->string('carousel_subtitle')->nullable();
            $table->string('carousel_image')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_text')->nullable();
            $table->string('about_image')->nullable();
            $table->string('news_title')->nullable();
            $table->text('news_items')->nullable();
            $table->string('documents_title')->nullable();
            $table->text('documents_list')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepage_contents');
    }
};
