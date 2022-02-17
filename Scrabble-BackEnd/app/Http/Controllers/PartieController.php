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
     *      path="/v1/partie/{idJoueur}",
     *      operationId="getPartieById",
     *      tags={"partie"},
     *      summary="retourne la partie et ses joueurs avec id partie",
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
     *      description="partie inexistant"
     *   ),
     *  )
     */
    public function getPartieById($idJoueur)
    {



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
        //return new JsonResponse($p);
        $p->joueurs = $partie2->joueurs()->where('statutJoueur',1)->get();
       // if(in_array($joueur, $p->joueurs)){
            return new JsonResponse($p);
        //}else{
         //   return new JsonResponse();
       // }

    }



}
