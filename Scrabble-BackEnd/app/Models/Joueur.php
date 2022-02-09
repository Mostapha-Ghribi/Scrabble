<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{

    public function partie()
    {
        return $this->belongsTo(Partie::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, "envoyeur");
    }

    use HasFactory;
    protected $fillable = ['nom', 'photo','partie','chevalet','score'];
    public $timestamps = false;


}
