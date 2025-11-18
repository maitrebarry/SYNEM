<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('homepage_carousel_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('homepage_content_id');
            $table->string('file');
            $table->timestamps();
            $table->foreign('homepage_content_id')->references('id')->on('homepage_contents')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('homepage_carousel_images');
    }
};
