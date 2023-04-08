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
        Schema::table('movie_keywords', function (Blueprint $table) {
            $table->foreign(['movie_id'], 'movie_keywords_ibfk_1')->references(['movie_id'])->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_keywords', function (Blueprint $table) {
            $table->dropForeign('movie_keywords_ibfk_1');
        });
    }
};
