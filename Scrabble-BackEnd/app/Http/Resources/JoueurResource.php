<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
