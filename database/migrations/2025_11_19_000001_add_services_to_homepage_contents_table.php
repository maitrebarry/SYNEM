<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('homepage_contents')) {
            Schema::table('homepage_contents', function (Blueprint $table) {
                if (! Schema::hasColumn('homepage_contents', 'services_title')) {
                    $table->string('services_title')->nullable()->after('about_image');
                }
                if (! Schema::hasColumn('homepage_contents', 'services_items')) {
                    // store JSON array of service items: [{"title":"...","text":"...","icon":"..."},...]
                    $table->text('services_items')->nullable()->after('services_title');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('homepage_contents')) {
            Schema::table('homepage_contents', function (Blueprint $table) {
                if (Schema::hasColumn('homepage_contents', 'services_items')) {
                    $table->dropColumn('services_items');
                }
                if (Schema::hasColumn('homepage_contents', 'services_title')) {
                    $table->dropColumn('services_title');
                }
            });
        }
    }
};
