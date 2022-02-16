<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Joueur;
use App\Models\Message;

use App\Models\Partie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * retourner  Tous les messages a partir d'un partie ID
     */
    public function getMessageByPartieId($partieId)
    {
        return Partie::find($partieId)->messages()
            ->where('partie', $partieId)
            ->latest('dateCreation')
            ->get();
    }

    /**
     * retourner  Tous les messages a partir d'un partie ID
     */
    public function creerMessage(Request $request)
    {
        $message = Message::create($request->all());
        return new JsonResponse($message);
    }
}
