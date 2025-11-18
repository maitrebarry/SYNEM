<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('homepage_contents')) {
            Schema::table('homepage_contents', function (Blueprint $table) {
                if (! Schema::hasColumn('homepage_contents', 'compte_rendu_title')) {
                    $table->string('compte_rendu_title')->nullable()->after('news_items');
                }
                if (! Schema::hasColumn('homepage_contents', 'compte_rendu_content')) {
                    $table->text('compte_rendu_content')->nullable()->after('compte_rendu_title');
                }
                if (! Schema::hasColumn('homepage_contents', 'compte_rendu_images')) {
                    // store JSON string of filenames; cast to array in model
                    $table->text('compte_rendu_images')->nullable()->after('compte_rendu_content');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('homepage_contents')) {
            Schema::table('homepage_contents', function (Blueprint $table) {
                if (Schema::hasColumn('homepage_contents', 'compte_rendu_images')) {
                    $table->dropColumn('compte_rendu_images');
                }
                if (Schema::hasColumn('homepage_contents', 'compte_rendu_content')) {
                    $table->dropColumn('compte_rendu_content');
                }
                if (Schema::hasColumn('homepage_contents', 'compte_rendu_title')) {
                    $table->dropColumn('compte_rendu_title');
                }
            });
        }
    }
};
