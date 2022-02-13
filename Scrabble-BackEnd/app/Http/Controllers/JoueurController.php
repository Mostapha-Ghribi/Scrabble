<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoueurRequest;
use App\Http\Requests\StationPostRequest;
use App\Http\Resources\JoueurResource;
use App\Models\Joueur;
use App\Models\Partie;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;


class JoueurController extends Controller
{

    /**
     *
     * @OA\Get(
     *      path="/v1/joueur/{idJoueur}",
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
    public function getJoueur($idJoueur)
    {
        $joueur = DB::table('joueurs')->where('idJoueur', "=", $idJoueur)->get();
        if (!empty(json_decode($joueur))) {
            return new JsonResponse($joueur);
        }
        return Response()->json(["Erreur" => "le joueur n'existe pas"], 404);

    }








/**
*
* @OA\Post(
*   tags={"joueur"},
*   path="/v1/inscrire",
 *     summary="Inscrire un joueur",
*   @OA\Response(
*     response="200",
*     description="joueur inscrit avec succées",
*     @OA\JsonContent(
*       type="array",
*       @OA\Items(ref="#/components/schemas/Joueur")
*     )
*   ),
 *     @OA\Response(
 *          response="422",
 *          description="L'un des champs est invalide",
 *     @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *      ),
 *
 *
*   @OA\RequestBody(
*     description="Creer un joueur avec son nom,photo,partie ",
*     required=true,
*     @OA\MediaType(
*       mediaType="application/json",
*       @OA\Schema(ref="#/components/schemas/JoueurRequest")
*     )
*   )
* )
*
 */
    public function inscrire(JoueurRequest $request)
    {
        $validData = $request->validate([
            "nom" => "required|max:50",
            "partie" => "required|integer"
        ]);
        if(!$request->has('partie')){
            return Response()->json(["message" => "il faut selectionner un type de partie"], 404);
        }
        //recuper le joueur qui a le meme nom
        $joueur = Joueur::where('nom', $request->nom)->first();
        if ($joueur) {
            $actif = $joueur->statutJoueur;
        }
        //si le joueur existe et actif en meme temps
        if ($joueur && $actif) {
            return Response()->json(["message" => "le joueur est déja existant ou en cours de jouer"], 404);
        } else {
            // tous les champs sont obligatoires
            if (!$validData) {
                return Response()->json(["message" => "les champs sont obligatoires"], 404);
            }
            //recuperer le type de la partie
            $typePartie = $request->partie;
            //selectionner la partie ou le typepartie == $typePartie & le statut de la partie et en Attente
            $partie = DB::table('parties')->where([
                ['typePartie', '=', $typePartie],
                ['statutPartie', '=', 'EnAttente'],
            ])->first();
            // si le joueur ajouter son image

            //si la partie n'est pas existe ou bien le status de la partie different de "EnAttente"
            if (!$partie || $partie->statutPartie != "EnAttente") {
                $partieCreated = Partie::create(['typePartie' => $typePartie]);
                $joueur = Joueur::create(['nom' => $request->nom, 'photo' =>  $request->photo, 'partie' => $partieCreated->id]);
                return new JoueurResource($joueur);
            }
            //si la partie existe et sa statut == "EnAttente"
            if ($partie && $partie->statutPartie == "EnAttente") {
                $joueur = Joueur::create(['nom' => $request->nom, 'photo' => $request->photo, 'partie' => $partie->idPartie]);
                if ($partie->typePartie - $partie->nombreJoueurs == 1) {
                    DB::table('parties')
                        ->where('idPartie', $partie->idPartie)
                        ->increment('nombreJoueurs');
                    DB::table('parties')
                        ->where('idPartie', $partie->idPartie)
                        ->update(['statutPartie' => "EnCours"]);
                } else {
                    DB::table('parties')
                        ->where('idPartie', $partie->idPartie)
                        ->increment('nombreJoueurs');
                }
                return new JoueurResource($joueur);
            }
        }
    }


    /**
     * @OA\Get(
     *      path="/v1/joueurs",
     *      operationId="getJoueurs",
     *      tags={"joueur"},
     *      summary="la liste des joueurs",
     *      description="la liste des joueurs",
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
    public function getJoueurs()
    {
        return Joueur::all();
    }



}
