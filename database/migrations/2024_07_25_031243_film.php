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
        Schema::create('film', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug');
            $table->string('foto');
            $table->text('deskripsi');
            $table->string('url_vidio')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->foreign('id_kategori')->references('id')->on('kategoris')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('genre_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_film');
            $table->unsignedBigInteger('id_genre');

            $table->foreign('id_genre')->references('id')->on('genres')
                ->onDelete('cascade');
            $table->foreign('id_film')->references('id')->on('film')
                ->onDelete('cascade');
        });

        Schema::create('actor_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_actor');
            $table->unsignedBigInteger('id_film');

            $table->foreign('id_actor')->references('id')->on('actors')
                ->onDelete('cascade');
            $table->foreign('id_film')->references('id')->on('film')
                ->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor_film');
        Schema::dropIfExists('genre_film');
        Schema::dropIfExists('film');
    }
};
