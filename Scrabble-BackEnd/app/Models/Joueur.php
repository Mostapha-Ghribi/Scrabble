<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Joueur")
 * {
 * @OA\Property(
 *     property="nom",
 *     type="string",
 *     description="le nom du joueur"
 *   ),
 * @OA\Property(
 *     property="photo",
 *     type="text",
 *     description="photo du joueur"
 *   ),
 * @OA\Property(
 *     property="chevalet",
 *     type="string",
 *     description="la chevalet"
 *   ),
 * @OA\Property(
 *     property="score",
 *     type="integer",
 *     description="le score "
 *   ),
 * @OA\Property(
 *     property="statutJoueur",
 *     type="boolean",
 *     description="le statutJoueur "
 *   ),
 * @OA\Property(
 *     property="ordre",
 *     type="integer",
 *     description="l'ordre du joueur "
 *   ),
 * @OA\Property(
 *     property="partie",
 *     type="integer",
 *     description="la partie "
 *   ),
 *
 * }
 */
class Joueur extends Model
{

    public function partie()
    {
        return $this->belongsTo(Partie::class,'partie','idPartie');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, "envoyeur");
    }

    use HasFactory;

    protected $fillable = ['nom', 'photo', 'partie'];
    public $timestamps = false;
    protected $primaryKey = 'idJoueur';


}
