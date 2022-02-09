<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    public function joueurs()
    {
        return $this->hasMany(Joueur::class, "partie");
    }


    public function messages()
    {
        return $this->hasMany(Message::class, "partie");
    }

    use HasFactory;

    protected $fillable = ["typePartie","reserve","grille","statutPartie","tempsJoueur"];
    public $timestamps = false;
}
