<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;


class MessageFactory extends Factory
{
    protected $model=Message::class;
    public function definition()
    {
        return [
            'contenu'=>$this->faker->name() ,
            'statutMessage'=>true ,
            'partie'=>1,
            'envoyeur'=>rand(1,4)
        ];
    }
}
