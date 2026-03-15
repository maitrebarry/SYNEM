<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('militants')) {
            return;
        }

        if (!Schema::hasColumn('militants', 'nom')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->string('nom')->default('')->after('id');
            });
        }

        if (!Schema::hasColumn('militants', 'prenom')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->string('prenom')->default('')->after('nom');
            });
        }

        if (Schema::hasColumn('militants', 'card_number') && !Schema::hasColumn('militants', 'n_cartes_syndicale')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->renameColumn('card_number', 'n_cartes_syndicale');
            });
        }

        if (Schema::hasColumn('militants', 'local_coordination') && !Schema::hasColumn('militants', 'coordinations')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->renameColumn('local_coordination', 'coordinations');
            });
        }

        if (Schema::hasColumn('militants', 'phone') && !Schema::hasColumn('militants', 'tel')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->renameColumn('phone', 'tel');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('militants')) {
            return;
        }

        if (Schema::hasColumn('militants', 'n_cartes_syndicale') && !Schema::hasColumn('militants', 'card_number')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->renameColumn('n_cartes_syndicale', 'card_number');
            });
        }

        if (Schema::hasColumn('militants', 'coordinations') && !Schema::hasColumn('militants', 'local_coordination')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->renameColumn('coordinations', 'local_coordination');
            });
        }

        if (Schema::hasColumn('militants', 'tel') && !Schema::hasColumn('militants', 'phone')) {
            Schema::table('militants', function (Blueprint $table) {
                $table->renameColumn('tel', 'phone');
            });
        }

        $columnsToDrop = [];
        if (Schema::hasColumn('militants', 'nom')) {
            $columnsToDrop[] = 'nom';
        }
        if (Schema::hasColumn('militants', 'prenom')) {
            $columnsToDrop[] = 'prenom';
        }

        if ($columnsToDrop !== []) {
            Schema::table('militants', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }
};
