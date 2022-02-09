<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'photo'];
    public $timestamps = false;

    public function partie()
    {
        return $this->belongsTo(Partie::class);
    }


}
