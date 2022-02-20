<?php

namespace App\Http\Controllers;

use App\Events\getJoueurs;
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
     *      operationId="getJoueursByIdPartie",
     *      tags={"partie"},
     *      summary="retourne les joueurs d'une partie",
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
        $partie = Partie::where('idPartie',$idPartie)->first();
        if(empty(json_decode($partie))){
            return Response()->json(['message'=>'Partie inexistant'],404);
        }
        $partie2 = Partie::find($idPartie);
        $joueurs = $partie2->joueurs()->where('statutJoueur',1)->get();
        return new JsonResponse($joueurs);


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
        $joueur = Joueur::where('idJoueur',$idJoueur)->first();
        if(empty(json_decode($joueur))){
            return Response()->json(['message'=>'Joueur inexistant'],404);
        }
        $partie = Partie::where('idPartie',$joueur->partie);
        $partie2 = Partie::find($joueur->partie);
        $p = $partie->first();
        $p->joueurs = $partie2->joueurs()->where('statutJoueur',1)->get();
        event(new getJoueurs($p->idPartie,$p->typePartie));
        return new JsonResponse($p);

    }



}
