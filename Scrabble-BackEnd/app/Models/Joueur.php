<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(schema="Joueur")
 * {
 *   @OA\Property(
 *     property="nom",
 *     type="string",
 *     description="le nom du joueur"
 *   ),
 *   @OA\Property(
 *     property="photo",
 *     type="string",
 *     description="The station title"
 *   ),
 *   @OA\Property(
 *     property="chevalet",
 *     type="string",
 *     description="The station title"
 *   ),
 *   @OA\Property(
 *     property="statutJoueur",
 *     type="string",
 *     description="The station title"
 *   ),
 *   @OA\Property(
 *     property="ordre",
 *     type="string",
 *     description="The station title"
 *   ),
 * }
 */
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
    protected $fillable = ['nom', 'photo','partie'];
    public $timestamps = false;


}
