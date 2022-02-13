<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PartieController extends Controller
{
    /**
     *
     * @OA\Get(
     *      path="/v1/partie/{idPartie}",
     *      operationId="getJoueursByIdPartie",
     *      tags={"partie"},
     *      summary="Trouver les joueurs d'une partie par id partie",
     *
     *  @OA\Parameter(
     *      name="idPartie",
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
     *      description="partie inexistant"
     *   ),
     *  )
     */
    public function getJoueursByIdPartie($idPartie)
    {
        $joueurs = DB::table('joueurs')->where('partie', "=", $idPartie)->get();
        if (!empty(json_decode($joueurs))) {
            return new JsonResponse($joueurs);
        }
        return Response()->json(["Erreur" => "Cette Partie n'existe pas"], 404);

    }

    /**
     *
     * @OA\Get(
     *      path="/v1/partie/joueur/{idJoueur}",
     *      operationId="getJoueursPartieByIdPlayer",
     *      tags={"partie"},
     *      summary="Trouver les joueurs d'une partie par id joueur",
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
     *      description="Joueur inexistant"
     *   ),
     *  )
     */
    public function getJoueursPartieByIdPlayer($idJoueur)
    {
        $joueur = DB::table('joueurs')->where('idJoueur','=',$idJoueur)->get();
        if(empty(json_decode($joueur))){
            return Response()->json(['message'=>'Joueur inexistant'],404);
        }
        $joueurs = DB::table('joueurs')->where('partie', "=", $joueur[0]->partie)->get();
        if (!empty(json_decode($joueurs))) {
            return new JsonResponse($joueurs);
        }
    }
}
