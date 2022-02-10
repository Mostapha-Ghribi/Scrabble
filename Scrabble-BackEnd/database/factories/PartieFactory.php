<?php

namespace Database\Factories;

use App\Models\Partie;
use Illuminate\Database\Eloquent\Factories\Factory;


class PartieFactory extends Factory
{


    protected $model = Partie::class;


    public function definition()
    {
        $statupartie = ["enAttente", "enCours", "finie"];
        return [
            "typePartie" => 4,
            "reserve" => "a:7|b:1|c:2|d:2|e:13|f:2|g:2|h:2|i:5|j:1|k:1|l:4|m:3|n:1|o:6|p:1|q:1|r:4|s:6|t:1|u:6|v:0|w:0|x:1|y:1|z:0| :1",
            "grille" => "",
            "statutPartie" => $statupartie[1],
            "tempsJoueur" => random_int(1, 300)
        ];
    }
}
