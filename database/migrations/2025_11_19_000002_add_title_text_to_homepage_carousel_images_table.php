<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('homepage_carousel_images')) {
            Schema::table('homepage_carousel_images', function (Blueprint $table) {
                if (! Schema::hasColumn('homepage_carousel_images', 'title')) {
                    $table->string('title')->nullable()->after('file');
                }
                if (! Schema::hasColumn('homepage_carousel_images', 'text')) {
                    $table->text('text')->nullable()->after('title');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('homepage_carousel_images')) {
            Schema::table('homepage_carousel_images', function (Blueprint $table) {
                if (Schema::hasColumn('homepage_carousel_images', 'text')) {
                    $table->dropColumn('text');
                }
                if (Schema::hasColumn('homepage_carousel_images', 'title')) {
                    $table->dropColumn('title');
                }
            });
        }
    }
};
