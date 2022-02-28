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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('idMessage');
            $table->timestamp('dateCreation')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->text('contenu');
            $table->boolean('statutMessage')->default(true);
            $table->integer('partie')->unsigned();
            $table->foreign('partie')->references('idPartie')->on('parties');
            $table->integer('envoyeur')->unsigned();
            $table->foreign('envoyeur')->references('idJoueur')->on('joueurs');
        });
    }


    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
