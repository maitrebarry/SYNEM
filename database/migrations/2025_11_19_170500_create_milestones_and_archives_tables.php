<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('ordering')->default(0);
            $table->timestamps();
        });

        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->integer('ordering')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('milestones');
        Schema::dropIfExists('archives');
    }
};
