<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;




/**
 * @OA\Schema(schema="joueurResource")
 * {
 *   @OA\Property(
 *    property="nom",
 *    type="string",
 *    description="Le nom du joueur"
 *    ),
 *    @OA\Property(
 *       property="photo",
 *       type="string",
 *       description="La photo du joueur"
 *    ),
 *    @OA\Property(
 *       property="partie",
 *       type="number",
 *       description="la partie associée au joueur"
 *    ),
 *    @OA\Property(
 *       property="chevalet",
 *       type="string",
 *       description="Le chevalet du joueur"
 *    ),
 *    @OA\Property(
 *       property="statutJoueur",
 *       type="string",
 *       description="la statut du joueur"
 *    ),
 *    @OA\Property(
 *       property="ordre",
 *       type="integer",
 *       description="L'ordre du joueur"
 *    ),
 * }
 */

class JoueurResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idJoueur' => $this->idJoueur,
            'nom' => $this->nom,
            'photo' => $this->photo,
            'chevalet' => $this->chevalet,
            'statutJoueur' => $this->statutJoueur,
            'ordre' => $this->ordre
        ];
    }
}
