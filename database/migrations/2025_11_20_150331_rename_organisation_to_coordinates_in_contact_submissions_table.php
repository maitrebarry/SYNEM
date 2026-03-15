<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('contact_submissions')) {
            return;
        }

        $hasOrganisation = Schema::hasColumn('contact_submissions', 'organisation');
        $hasCoordinates = Schema::hasColumn('contact_submissions', 'coordinates');

        if ($hasOrganisation && !$hasCoordinates) {
            Schema::table('contact_submissions', function (Blueprint $table) {
                $table->renameColumn('organisation', 'coordinates');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('contact_submissions')) {
            return;
        }

        $hasOrganisation = Schema::hasColumn('contact_submissions', 'organisation');
        $hasCoordinates = Schema::hasColumn('contact_submissions', 'coordinates');

        if ($hasCoordinates && !$hasOrganisation) {
            Schema::table('contact_submissions', function (Blueprint $table) {
                $table->renameColumn('coordinates', 'organisation');
            });
        }
    }
};
