<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments("idPartie");
            $table->integer("typePartie");
            $table->string("reserve", 102)->default("AAAAAAAAABBCCDDDEEEEEEEEEEEEEEEFFGGHHIIIIIIIIJKLLLLLMMMNNNNNNOOOOOOPPQRRRRRRSSSSSSTTTTTTUUUUUUVVWXYZ**");
            $table->string("grille", 225)->default("");
            $table->integer('nombreJoueurs')->default(1);
            $table->timestamp("dateCreation")->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp("dateDebutPartie")->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp("dateFinPartie")->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->string("statutPartie")->default("EnAttente");
            $table->integer("tempsJoueur")->default(300);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parties');
    }
};
