<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

class MessageController extends Controller
{
    /**
     * retourner tous les message  triée par dateCreation
     */
    public function index()
    {
        return Message::latest('dateCreation')->get();
    }

    /**
     * retourner un  message  pard idMeddage
     */
    public function getMessageById($idMessage)
    {
        return Message::find($idMessage)->first();
    }

    /**
     * retourner  Tous les messaege d'unn joueur a partir de son id
     */
    public function getMessageByPlayerId($playerId)
    {
        return Joueur::find($playerId)->messages()
            ->where('envoyeur', $playerId)
            ->latest('dateCreation')
            ->get();
    }
}
