<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="MessageResource")
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
class MessageResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'dateCreation' => $this->dateCreation,
            'contenu' => $this->contenu,
            'statutMessage' => $this->statutMessage,
            'partie' => $this->partie,
            'envoyeur' => $this->envoyeur

        ];
    }
}
