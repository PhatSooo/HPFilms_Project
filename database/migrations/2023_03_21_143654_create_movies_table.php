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
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('movie_id');
            $table->string('title');
            $table->text('overview')->nullable();
            $table->integer('runtime')->nullable();
            $table->integer('movie_status')->default(0);
            $table->text('tagline')->nullable();
            $table->timestamps();
            $table->char('slug', 100)->nullable()->unique();
            $table->string('image')->nullable();
            $table->string('trailer', 100)->nullable();
            $table->dateTime('date_release')->nullable();
            $table->integer('production_country_id')->nullable();
            $table->integer('series')->nullable();
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
