<?php

namespace Database\Seeders;

use App\Models\Joueur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JoueursTableSeeder extends Seeder
{

    public function run()
    {
        Joueur::factory()->count(4)->create() ;
    }
}
