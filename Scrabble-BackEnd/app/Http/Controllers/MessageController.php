<?php

namespace App\Http\Controllers;


use App\Models\Joueur;
use App\Models\Message;

use App\Models\Partie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     *
     * @OA\Post(
     *   tags={"message"},
     *   path="/v1/message",
     *     summary="Ecrire un message",
     *   @OA\Response(
     *     response="200",
     *     description="Message envoyé avec succées",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Message")
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
     *     description="Creer un Message avec son contenu,envoyeur,partie ",
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(ref="#/components/schemas/Message")
     *     )
     *   )
     * )
     *
     */

    public function creerMessage(Request $request)
    {
        $ligneArray = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o"];
        $posArray = ["h", "v"];
        $joueur = Joueur::find($request->envoyeur);
        $partie = Partie::find($request->partie);
        $ordre = $request->ordre;
        $contenu = trim($request->contenu);
        if ($contenu[0] !== '!') {
            $message = Message::create($request->all());
            return new JsonResponse($message);
        }

        // verifier si le joueur est deja partant de la partie courante
        if ($joueur->partie !== $request->partie) {
            return new JsonResponse([
                "nom" => $joueur->nom,
                "partie" => $partie->idPartie,
                'message' => "$joueur->nom vous n'êtes pas autorisée a envoyer des message dans cette partie",
            ], 404);
        }

        $commande = substr($contenu, 1, strpos($contenu, ' ') - 1);
        switch ($commande) {

            case 'placer' :
                $coordonnesContenu = substr($contenu, strpos($contenu, ' ') + 1);
                $coordonnes = substr($coordonnesContenu, 0, strpos($coordonnesContenu, ' '));
                $mot = substr($coordonnesContenu, strpos($coordonnesContenu, ' ') + 1);
                $ligne = $coordonnes[0];
                $coordonnes = substr($coordonnes, 1);
                $position = substr($coordonnes, -1);
                $coordonnes = substr($coordonnes, 0, -1);
                $colonne = (int)$coordonnes;

                // tester si les coordonnes sont  invalide
                if (!in_array($ligne, $ligneArray, true) || !in_array($position, $posArray) || empty($mot)) {
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom  Erreur de syntaxe",
                        'mot' => $mot,
                    ], 404);
                }
                //verifier l'inexistance des espace entres les caracteres d'un mot
                //la chaine doit etre alphabetique
                // la longeur du mot doit etre <= longeur de chevalet
                if (str_contains(trim($mot), ' ') ||
                    strlen(trim($mot)) < 2 ||
                    !ctype_alpha(trim($mot)) ||
                    (strlen($mot) > strlen($joueur->chevalet) ) ||
                    $this->verifierPostionMotValable($ligne, $colonne, $position, $mot)===false
                ) {
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom  Commande impossible a realiser",
                        'mot' => $mot,
                        "test" => strlen($mot) > strlen($joueur->chevalet)
                    ], 404);
                }



                break;
            case 'changer' :
                break;


            case 'passer' :

                break;
            case 'aider' :
                break;


            default :
                return new JsonResponse([
                    "nom" => $joueur->nom,
                    "partie" => $partie->idPartie,
                    'message' => "$joueur->nom  Commande impossible a realiser",
                    'mot' => $commande,
                ], 404);


        }


    }









    //? verifier si un mot contient un caractere Majuscule
    public function verifierMotContientLettreMajuscule($mot): bool
    {
        // ? verfier si toute la chaine est en Minuscule
        $mot = trim($mot);
        $chaineMinuscule = ctype_lower($mot);
        if ($chaineMinuscule) {
            return true;
        }
        return false;
    }

    public function verifierPostionMotValable($ligne, $colonne, $pos, $mot)
    {
        // g15v bonjour
        $longeurchaine = strlen($mot);
        if ($pos === 'v') {
            $limiteLigne = ord('P') - ord(strtoupper(trim($ligne)));
            return ($limiteLigne >= $longeurchaine);
        }
        $limiteColonne = 16 - $colonne;
        return ($limiteColonne >= $longeurchaine);
    }








}
