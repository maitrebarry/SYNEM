<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('about_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->text('about_text')->nullable();
            $table->string('stats_members')->nullable();
            $table->string('stats_years')->nullable();
            $table->string('stats_regions')->nullable();
            $table->string('stats_trainings')->nullable();
            $table->json('timeline')->nullable();
            $table->json('team')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('about_page_contents');
    }
};
