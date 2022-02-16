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
     * retourner un  message a partir de son  Id
     */

    /**
     *
     * @OA\Get(
     *      path="/v1/message/{idMessage}",
     *      operationId="getMessageById",
     *      tags={"message"},
     *      summary="Trouver un Message a partir  de son id",
     *
     *  @OA\Parameter(
     *      name="idMessage",
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
        return Message::findOrFail($idMessage);
    }


    /*  =====================================================================================================================================
        =====================================================================================================================================
     */

    /**
     * retourner  Tous les messaege d'unn joueur a partir de son id
     */


    /**
     *
     * @OA\Get(
     *      path="/v1/messages/joueur/{idJoueur}",
     *      operationId="getMessageByPlayerId",
     *      tags={"message"},
     *      summary="Trouver un Message a partir  de l'ID d'un joueur",
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


    public function getMessageByPlayerId($idJoueur)
    {
        return Joueur::find($idJoueur)->messages()
            ->where('envoyeur', $idJoueur)
            ->latest('dateCreation')
            ->get();
    }
    /*  =====================================================================================================================================
          =====================================================================================================================================
       */


    /**
     * retourner  Tous les messages a partir d'un partie ID
     */

    /**
     *
     * @OA\Get(
     *      path="/v1/messages/partie/{partieId}",
     *      operationId="getMessageByPartieId",
     *      tags={"message"},
     *      summary="Trouver Tous les  Messages a partir  de l'ID d'une partie",
     *
     *  @OA\Parameter(
     *      name="partieId",
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


    public function getMessageByPartieId($partieId)
    {
        return Partie::find($partieId)->messages()
            ->where('partie', $partieId)
            ->latest('dateCreation')
            ->get();
    }
    /*  =====================================================================================================================================
          =====================================================================================================================================
       */
    /**
     * retourner  Tous les messages a partir d'un partie ID
     */
    public function creerMessage(Request $request)
    {
        $message = Message::create($request->all());
        return new JsonResponse($message);
    }
}
