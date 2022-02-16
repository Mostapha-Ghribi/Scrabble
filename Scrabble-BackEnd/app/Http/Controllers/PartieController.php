<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\Partie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use stdClass;

class PartieController extends Controller
{
    /**
     *
     * @OA\Get(
     *      path="/v1/partie/{idPartie}",
     *      operationId="getPartieById",
     *      tags={"partie"},
     *      summary="retourne la partie et ses joueurs avec id partie",
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
    public function getPartieById($idPartie)
    {
        $partie = Partie::find($idPartie);
        $p = $partie->first();
        $p->joueurs = $partie->joueurs()->where('statutJoueur',1)->get();
        if (!empty(json_decode($p))) {
            return new JsonResponse($p);
        }
        return Response()->json(["Erreur" => "Cette Partie n'existe pas"], 404);

    }

    /**
     *
     * @OA\Get(
     *      path="/v1/partie/joueur/{idJoueur}",
     *      operationId="getPartieByIdJoueur",
     *      tags={"partie"},
     *      summary="recuperer la partie et ses joueurs avec id joueur",
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
    public function getPartieByIdJoueur($idJoueur)
    {
        $joueur = Joueur::find($idJoueur)->first();
        if(empty(json_decode($joueur))){
            return Response()->json(['message'=>'Joueur inexistant'],404);
        }
        $partie = Partie::find($joueur->partie);
        $p = $partie->first();
        $p->joueurs = $partie->joueurs()->where('statutJoueur',1)->get();
        return new JsonResponse($p);
    }

}
