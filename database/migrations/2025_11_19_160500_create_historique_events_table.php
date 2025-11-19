<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('historique_events', function (Blueprint $table) {
            $table->id();
            $table->string('year')->nullable();
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->integer('ordering')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historique_events');
    }
};
