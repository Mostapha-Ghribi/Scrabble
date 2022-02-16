<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Message")
 * {
 * @OA\Property(
 *     property="dateCreation",
 *     type="string",
 *     description="la dateCreation du message"
 *   ),
 * @OA\Property(
 *     property="contenu",
 *     type="string",
 *     description="Le contenu du message"
 *   ),
 * @OA\Property(
 *     property="statutMessage",
 *     type="boolean",
 *     description="le statut du  Message"
 *   ),
 * @OA\Property(
 *     property="partie",
 *     type="integer",
 *     description="la partie du  Message "
 *   ),
 * @OA\Property(
 *     property="envoyeur",
 *     type="integer",
 *     description="l envoyeur du Message "
 *   ),
 *
 *
 * }
 */
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

    protected $fillable = ['contenu', 'partie','envoyeur'];
    public $timestamps = false;
    protected $primaryKey = 'idMessage';
}
