<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('footers', function (Blueprint $table) {
            if (!Schema::hasColumn('footers', 'footer_description')) {
                $table->text('footer_description')->nullable()->after('organization_name');
            }

            if (!Schema::hasColumn('footers', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('linkedin_url');
            }

            for ($i = 4; $i <= 6; $i++) {
                $column = 'gallery_image_' . $i;
                if (!Schema::hasColumn('footers', $column)) {
                    $table->string($column)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('footers', function (Blueprint $table) {
            for ($i = 6; $i >= 4; $i--) {
                $column = 'gallery_image_' . $i;
                if (Schema::hasColumn('footers', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('footers', 'instagram_url')) {
                $table->dropColumn('instagram_url');
            }

            if (Schema::hasColumn('footers', 'footer_description')) {
                $table->dropColumn('footer_description');
            }
        });
    }
};
