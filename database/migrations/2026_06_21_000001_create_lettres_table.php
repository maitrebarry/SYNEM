<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lettres', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 60)->unique();
            $table->date('date_lettre');
            $table->text('destinataire');
            $table->string('objet');
            $table->longText('corps');
            $table->json('ampliations')->nullable();
            $table->string('signataire');
            $table->string('fonction_signataire');
            $table->string('cachet_path')->nullable();
            $table->json('pieces_jointes')->nullable();
            $table->boolean('est_publiee')->default(false);
            $table->boolean('est_telechargeable')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lettres');
    }
};
