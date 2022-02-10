<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('joueurs', function (Blueprint $table) {
            $table->increments('idJoueur');
            $table->string('nom', 50);
            $table->string('photo')->default('public/profile.png');
            $table->string('chevalet', 7)->nullable();
            $table->integer('score')->default(0);
            $table->boolean('statutJoueur')->default(1);
            $table->integer('ordre')->nullable();
            $table->integer('partie')->unsigned();
            $table->foreign('partie')->references('idPartie')->on('parties');

        });
    }


    public function down()
    {
        Schema::dropIfExists('joueurs');
    }
};
