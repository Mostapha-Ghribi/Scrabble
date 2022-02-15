<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
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
