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


    /**
     * @OA\Get(
     *      path="/v1/messages",
     *      operationId="index",
     *      tags={"message"},
     *      summary="la liste des messages",
     *      description="la liste des messages",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */

    public function index()
    {
        return Message::latest('dateCreation')->get();
    }

    /* =====================================================================================================================================
     =====================================================================================================================================
    */


    /**
     * retourner un  message  pard idMeddage
     */

    /**
     *
     * @OA\Get(
     *      path="/v1/message/{idMessage}",
     *      operationId="getJoueur",
     *      tags={"joueur"},
     *      summary="Trouver un joueur a partir  de son id",
     *
     *  @OA\Parameter(
     *      name="idJoueur",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     *    @OA\Response(
     *          response=200,
     *          description="Opération réussie",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="joueur inexistant"
     *   ),
     *  )
     */




    public function getMessageById($idMessage)
    {
        return Message::find($idMessage)->first();
    }


    /* =====================================================================================================================================
   =====================================================================================================================================
  */

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
