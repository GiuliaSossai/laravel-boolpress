<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoverPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //aggiungiamo due campi alla tabella posts, uno col nome de img dato da laravel e uno per il nome originale
            //nome colonna cover deve essere uguale al name dell'input corrispondente nel form create
            $table->string('cover')->nullable()->after('slug');
            $table->string('original_cover_name')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('cover');
            $table->dropColumn('original_cover_name');
        });
    }
}
