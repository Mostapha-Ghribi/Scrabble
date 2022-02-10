<?php

namespace Database\Factories;

use App\Models\Joueur;
use Illuminate\Database\Eloquent\Factories\Factory;

class JoueurFactory extends Factory
{
    protected $model = Joueur::class;

    public function definition()
    {
      /* $chevalet = ["A", "A", "B", "B", "C", "C", "D", "D", "D", "D", "E", "E", "F", "F", "G", "G", "H", "H", "I", "I"];
        $chevalet2 = array_rand($chevalet, 6);
        shuffle($chevalet2);
        $lettres = '';
        for ($i=0;$i<7;$chevalet2) {
            $lettres += $chevalet2[$i];
        }*/


        $nom = "haithem";
        return [
            'nom' => $nom . rand(1, 100),
            'photo' => 'h.png',
            'chevalet' =>"ABCDEZC",
            'score' => rand(1, 200),
            'statutJoueur' => true,
            'ordre' => 1,
            'partie' => 1
        ];
    }
}
