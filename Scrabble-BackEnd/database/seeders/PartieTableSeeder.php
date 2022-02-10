<?php

namespace Database\Seeders;

use App\Models\Partie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partie::factory()->count(1)->create() ;
    }
}
