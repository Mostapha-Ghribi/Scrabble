<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;




/**
 * @OA\Schema(schema="joueurs")
 * {
 *   @OA\Property(
 *    property="nom",
 *    type="string",
 *    description="The station name"
 *    ),
 *    @OA\Property(
 *       property="photo",
 *       type="string",
 *       description="The station title"
 *    ),
 *    @OA\Property(
 *       property="partie",
 *       type="number",
 *       description="The station latitude"
 *    ),
 *    @OA\Property(
 *       property="chevalet",
 *       type="string",
 *       description="The station longitude"
 *    ),
 *    @OA\Property(
 *       property="statutJoueur",
 *       type="string",
 *       description="The station longitude"
 *    ),
 *    @OA\Property(
 *       property="ordre",
 *       type="integer",
 *       description="The station longitude"
 *    ),
 * }
 */

class JoueurResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'nom' => $this->nom,
            'photo' => $this->photo,
            'chevalet' => $this->chevalet,
            'statutJoueur' => $this->statutJoueur,
            'ordre' => $this->ordre
        ];
    }
}
