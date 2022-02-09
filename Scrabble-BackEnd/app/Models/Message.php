<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function partie()
    {
        return $this->belongsTo(Partie::class);
    }

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }


    use HasFactory;

    protected $fillable = ['contenu'];
    public $timestamps = false;

}
