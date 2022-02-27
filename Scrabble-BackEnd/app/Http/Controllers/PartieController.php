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
     *      path="/v1/partie/{idPartie}/joueurs",
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
     * @throws \JsonException
     */
    public function getJoueursByIdPartie($idPartie): JsonResponse
    {
        $partie = Partie::where('idPartie',$idPartie)->first();
        if(empty(json_decode($partie, false, 512, JSON_THROW_ON_ERROR))){
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
     * @throws \JsonException
     */
    public function getPartieByIdJoueur($idJoueur): JsonResponse
    {
        $joueur = Joueur::where('idJoueur',$idJoueur)->first();
        if(empty(json_decode($joueur, false, 512, JSON_THROW_ON_ERROR))){
            return Response()->json(['message'=>'Joueur inexistant'],404);
        }
        $partie = Partie::where('idPartie',$joueur->partie);
        $partie2 = Partie::find($joueur->partie);
        $p = $partie->first();
        $messages = Partie::find($joueur->partie)->messages()
            ->where('partie', $joueur->partie)
            ->latest('dateCreation')
            ->get();
        $m = [];
        foreach ($messages as $message){
            $joueur = Joueur::where('idJoueur' , $message->envoyeur)->first();
            $me= new stdClass();
            $me->nom = $joueur->nom;
            $me->contenu = $message->contenu;
            array_push($m , $me);
        }
        $p->joueurs = $partie2->joueurs()->where('statutJoueur',1)->get();
        $p->messages = $m;
        event(new getJoueurs($p->idPartie,$p->typePartie));
        return new JsonResponse($p);

    }
    public function getPartieByIdJoueurBind($idJoueur): JsonResponse
    {
        $joueur = Joueur::where('idJoueur',$idJoueur)->first();
        if(empty(json_decode($joueur, false, 512, JSON_THROW_ON_ERROR))){
            return Response()->json(['message'=>'Joueur inexistant'],404);
        }
        $partie = Partie::where('idPartie',$joueur->partie);
        $partie2 = Partie::find($joueur->partie);
        $p = $partie->first();
        $messages = Partie::find($joueur->partie)->messages()
            ->where('partie', $joueur->partie)
            ->latest('dateCreation')
            ->get();
        $m = [];
        foreach ($messages as $message){
            $joueur = Joueur::where('idJoueur' , $message->envoyeur)->first();
            $me= new stdClass();
            $me->nom = $joueur->nom;
            $me->contenu = $message->contenu;
            array_push($m , $me);
        }
        $p->joueurs = $partie2->joueurs()->where('statutJoueur',1)->get();
        $p->messages = $m;
        return new JsonResponse($p);

    }

    /**
     *
     * @OA\Get(
     * tags={"partie"},
     * path="/v1/addChevalet/partie/{idPartie}",
     * summary="//TODO",
     * @OA\Response(
     *    response="422",
     *    description="L'un des champs est invalide",
     *    ),
     *   @OA\Parameter(
     *      name="idPartie",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      ),
     *   ),
     * )
     * @throws \Exception
     */
    public function InitChevaletAndReserve($idPartie): JsonResponse
    {
        $partie = Partie::where('idPartie',$idPartie);
        $partie2 = Partie::find($idPartie);
        $p = $partie->first();
        $p->joueurs = $partie2->joueurs()->where('statutJoueur',1)->get();
        $reserve = $p->reserve;
        foreach ($p->joueurs as $i => $iValue) {
           $idJoueur =  $iValue->idJoueur;
           if($iValue->chevalet === '') {
               $chevaletJoueur = "";
               for ($j = 0; $j < 7; $j++) {
                   $chevaletJoueur .= $reserve[random_int(0, strlen($reserve) - 1)];
                   $strpos = strpos($reserve, $chevaletJoueur[$j]);
                   $reserve = substr($reserve, 0, $strpos) . substr($reserve, $strpos + 1);
               }
               DB::table('joueurs')
                   ->where('idJoueur', $idJoueur)
                   ->update(['chevalet' => $chevaletJoueur,'ordre' => $i+1]);
               DB::table('parties')
                   ->where('idPartie', $idPartie)
                   ->update(['reserve' => $reserve]);
           }
        }
        $partieAfter = Partie::where('idPartie',$idPartie);
        $partieAfter2 = Partie::find($idPartie);
        $pAfter = $partieAfter->first();
        $pAfter->joueurs = $partieAfter2->joueurs()->where('statutJoueur',1)->get();
        return new JsonResponse($pAfter);
    }
}
