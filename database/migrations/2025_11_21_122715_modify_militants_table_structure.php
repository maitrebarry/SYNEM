<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('militants', function (Blueprint $table) {
            // Ajouter les nouveaux champs
            $table->string('nom')->after('id');
            $table->string('prenom')->after('nom');

            // Renommer card_number en n_cartes_syndicale
            $table->renameColumn('card_number', 'n_cartes_syndicale');

            // Renommer local_coordination en coordinations
            $table->renameColumn('local_coordination', 'coordinations');

            // Renommer phone en tel
            $table->renameColumn('phone', 'tel');

            // Garder email tel quel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('militants', function (Blueprint $table) {
            // Supprimer les nouveaux champs
            $table->dropColumn(['nom', 'prenom']);

            // Remettre les anciens noms
            $table->renameColumn('n_cartes_syndicale', 'card_number');
            $table->renameColumn('coordinations', 'local_coordination');
            $table->renameColumn('tel', 'phone');
        });
    }
};
