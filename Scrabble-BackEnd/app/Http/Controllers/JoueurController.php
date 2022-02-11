<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoueurRequest;
use App\Http\Requests\StationPostRequest;
use App\Http\Resources\JoueurResource;
use App\Models\Joueur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;


class JoueurController extends Controller
{


    /**
     * @OA\Get(
     *      path="/v1/joueur/{idJoueur}",
     *      operationId="getJoueur",
     *      tags={"joueurs"},
     *      summary="Trouver un joueurs a partie son id ",
     *      description="Trouver un joueurs a partie son id",
     *@OA\Parameter(
     *      name="idJoueur",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      ),
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
    public function getJoueur($idJoueur)
    {
        $joueur = DB::table('joueurs')->where('idJoueur', "=", $idJoueur)->get();
        if (!empty(json_decode($joueur))) {
            return new JsonResponse($joueur);
        }
        return Response()->json(["Erreur" => "le joueur n'existe pas"], 401);

    }








/**
*
* @OA\Post(
*   tags={"joueurs"},
*   path="/api/v1/inscrire",
*   @OA\Response(
*     response="201",
*     description="Returns the created station",
*     @OA\JsonContent(
*       type="array",
*       @OA\Items(ref="#/components/schemas/Joueur")
*     )
*   ),
*   @OA\RequestBody(
*     description="joueurs to create",
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
            "photo" => "mimes:jpg,bmp,png,jpeg",
            "partie" => "integer"
        ]);
        if (!$validData) {
            return Response()->json(["Erreur" => "les champs sont obligatoires"], 401);
        }
        $joueur = Joueur::where('nom', $request->nom)->first();
        if ($joueur) {
            $actif = $joueur->statutJoueur;
        }
        if ($joueur && $actif) {
            return Response()->json(["Erreur" => "le joueur est déja existant ou en cours de jouer"], 401);
        } else {
            $filename = "";
            if ($request->hasFile('photo')) {
                $filename = $request->file('photo')->store('joueurs', 'public');
                $request->photo = $filename . "." . $request->photo->getClientOriginalExtension();
            } else {
                $filename = 'public/profile.png';
            }
            $joueur = Joueur::create($request->all());
            return new JoueurResource($joueur);
        }

    }


    /**
     * @OA\Get(
     *      path="/v1/joueurs",
     *      operationId="getJoueurs",
     *      tags={"joueurs"},
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
