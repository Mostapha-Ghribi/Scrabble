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
        $envoyeur = Joueur::find($request->envoyeur);

        //? verifier si le joueur est deja partant de la partie courante
        if ($envoyeur->partie !== $request->partie) {
            return new JsonResponse([
                "nom" => $joueur->nom,
                "partie" => $partie->idPartie,
                'message' => "$joueur->nom vous n'êtes pas autorisée a envoyer des message dans cette partie",
            ], 404);

        }
        //? verifier les champs qui doivent etre obligatoire
        if (!$request->has("contenu") || !$request->has("envoyeur") || !$request->has("partie")) {
            return new JsonResponse(['message' => "Tout les champs sont obligatoires"], 404);
        }


        //? verifier le type de la commande
        $commande = trim($request->contenu);
        if (!str_starts_with($commande, "!")) {
            //? ajouter le message ordinaire
            $message = Message::create($request->all());
            return new JsonResponse($message);
        }
        //? verifier si c'est une commande placée EXEMPLE  !placer g15v bonjour
        $commandePlacer = substr($commande, 1, 6);
        $commandeChanger = substr($commande, 1, 7);
        $commandePasser = substr($commande, 1, 7);
        $commandeAider = substr($commande, 1, 5);
        if ($commandePlacer === "placer") {
            //! sauf lorsqu’il s’agit d’une lettre blanche, qui elle, doit être entrée en
            //! majuscule. Le mot doit être écrit au complet en y incluant, si nécessaire, les lettres se trouvant
            //! déjà sur le plateau de jeu
            //? nouvelle commande contiennent par EXEMPLE g15v
            $nouvelleCommande = substr($commande, 8, 4);
            //? verifier si la longeur de la chaine est égale a 3 exemples g5v
            if ($nouvelleCommande[strlen($nouvelleCommande) - 1] === ' ') {
                //? recuperation de LIGNE  COLONNE POSITION
                $lg = $nouvelleCommande[0];
                $col = $nouvelleCommande[1];
                $posit = $nouvelleCommande[2];
                //? verifier si la ligne est correcte => retourne boolean
                $ligneCommande = in_array($lg, $ligneArray);
                //? verifier si la colonne est correcte => retourne boolean
                $colonneisNumber = is_numeric($nouvelleCommande[1]);
                //? verifier si la colonne est un numero valid
                $colonneisNumberValid = (((int)$nouvelleCommande[1]) <= 9) && ((int)$nouvelleCommande[1] >= 1);
                //? verifier si la position est correcte => retourne boolean
                $pos = in_array($nouvelleCommande[2], $posArray);
                //? recuperer le mot a remplacer
                $motAplacer = substr($commande, 11, strlen($commande));

                //? verifier l'existance des condition
                if ($ligneCommande && $colonneisNumber && $colonneisNumberValid && $pos
                    && $this->verifierPostionMotValable($lg, $col, $posit, $motAplacer) && $this->verfierMotFranacaisValide(trim($motAplacer))) {
                    //? creer le message dans la base de donnes
                    $message = new Message;
                    $message->contenu = $request->contenu;
                    $message->envoyeur = $request->envoyeur;
                    $message->partie = $request->partie;
                    $message->statutMessage = 0;
                    $message->save();
                    // ? retourner les information de placement de lettres
                    // TODO placer le mot
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom a Placée le mot  $motAplacer",
                        'mot' => $motAplacer,
                        'statutMessage' => $message->statutMessage
                    ], 200);
                }
                return new JsonResponse([
                    "nom" => $joueur->nom,
                    "partie" => $partie->idPartie,
                    'message' => "$joueur->nom  Commande impossible a realiser",
                    'mot' => $motAplacer,
                ], 404);

            } else {
                //? verifier si la ligne est correcte => return boolean
                $ligneCorrecte = in_array($nouvelleCommande[0], $ligneArray, true);
                //? recuperer la colonne => return string
                $colIsNumber = substr($nouvelleCommande, 1, 2);
                //? verifier la colonne est correcte => return boolean
                $coloneCorrecte = is_numeric($colIsNumber) && ((int)$colIsNumber <= 15);
                //? verifier la position est correcte => return boolean
                $posCorrecte = in_array($nouvelleCommande[3], $posArray, true);
                //? verifier si la chaine est inexistante
                $mot = substr($commande, 12);
                if (empty($mot)) {
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom Erreur de syntaxe",
                        'mot' => "$mot",
                    ], 404);
                }
                //? verifier si la mot est en position valable dans la grille
                $verifierMot = $this->verifierPostionMotValable($nouvelleCommande[0], (int)$colIsNumber, $nouvelleCommande[3], $mot);
                // ? tester l'existance des conditions
                if ($ligneCorrecte && $coloneCorrecte && $posCorrecte && $verifierMot && $this->verfierMotFranacaisValide(trim($mot))) {
                    // ?  creer un message dans la base de donnes
                    $message = new Message;
                    $message->contenu = $request->contenu;
                    $message->envoyeur = $request->envoyeur;
                    $message->partie = $request->partie;
                    $message->statutMessage = 0;
                    $message->save();
                    //? retourner le résultat
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom  a Placée le mot $mot",
                        'statutMessage' => $message->statutMessage,
                    ], 200);
                }
                //? retourner Une commande impossible à réaliser
                return new JsonResponse([
                    "nom" => $joueur->nom,
                    "partie" => $partie->idPartie,
                    'message' => "$joueur->nom Une commande impossible à réaliser",
                    'mot' => $mot,
                ], 404);
            }

            //  ============================================CHANGER LETTRE=======================================================================>
            /* Changer des lettres  */
        } elseif ($commandeChanger === "changer") {
            // changer des lettre exemple !changer mw*
            $LettreChanger = substr($commande, 8, strlen($commande));
            if (!empty($LettreChanger)) {
                // TODO lettre alphabetiue et  le contiennet *
                // TODO verifier si les lettres sont inclus dans le chavalet du joueur
                // return new JsonResponse(['Les lettres a echanger' => $LettreChanger], 200);
                $message = new Message;
                $message->contenu = $request->contenu;
                $message->envoyeur = $request->envoyeur;
                $message->partie = $request->partie;
                $message->statutMessage = 0;
                $message->save();
                return new JsonResponse([
                    "nom" => $joueur->nom,
                    "partie" => $partie->idPartie,
                    'message' => "$joueur->nom a changer les lettres $LettreChanger",
                    'statutMessage' => "$message->statutMessage",
                ], 200);

            }
            //return new JsonResponse(['Aucune lettre a changer' => $LettreChanger], 404);
            return new JsonResponse([
                "nom" => $joueur->nom,
                "partie" => $partie->idPartie,
                'message' => "$joueur->nom Erreur de syntaxe ",
                'mot' => "$LettreChanger",
            ], 404);
            //  ============================================AIDER=======================================================================>

        } elseif ($commandeAider === "aider") {
            $message = new Message;
            $message->contenu = $request->contenu;
            $message->envoyeur = $request->envoyeur;
            $message->partie = $request->partie;
            $message->statutMessage = 0;
            $message->save();
            return new JsonResponse([
                "nom" => $joueur->nom,
                "partie" => $partie->idPartie,
                'statutMessage' => "$message->statutMessage",
                'message' => "!placer g15v bonjour  ===> joue le mot bonjour à la verticale et le b est positionné en g15
                        changer un lettre avec  ===>  !changer mwb : remplace les lettres m, w et b.
                        !changer e*  =>  remplace une seule des lettres e et une lettre blanche
                        Passer son tour ===> !passer
                          Besoin d aide ===>  !aider ",

            ], 200);

        } elseif ($commandeAider === "passer") {
            return true;
        } else {
            return new JsonResponse([
                "nom" => $joueur->nom,
                "partie" => $partie->idPartie,
                'message' => "$joueur->nom fait une commande impossible à realiser",
            ], 404);
        }


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


    // verifier si le mot est dans grille est-elle dans le chevalet et placer un mot dans la grille
    public function placerMot($ligne, $colonne, $pos, $mot, $grille)
    {
        // convertir la grille en d'une chaine vers un tableau
        $grillTab = str_split($grille);
        // retourner la position du mot dans le tableau (grille sous forme d'un tableau)
        $posMotTableau = (ord(strtoupper($ligne) - ord('A'))) * 15 + $colonne - 1;
        // tableau de lettres dans la position de la grille
        $motGrille = [];
        switch ($pos) {
            case 'v' :
                for ($i = $posMotTableau, $iMax = $posMotTableau + strlen($mot); $i <= $iMax; $i++) {
                    $motGrille[$i] = $grillTab[$i];
                }
                if (emptyArray(implode($motGrille))) {
                    // si la position de mot dans la grille est vide on la place
                    $counter = 0;
                    for ($i = $posMotTableau, $iMax = $posMotTableau + strlen($mot); $i <= $iMax; $i++) {
                        $grillTab[$i] = $motGrille[$counter];
                        $counter++;
                    }
                    return true;
                }
                $counter = 0;
                for ($i = $posMotTableau, $iMax = $posMotTableau + strlen($mot); $i <= $iMax; $i++) {
                    $grillTab[$i] = $motGrille[$counter];
                    $counter++;
                }
                return true;
                break;
            case 'h' :
                for ($i = $posMotTableau, $iMax = strlen($mot); $i <= $iMax; $i = 16) {
                    $motGrille[] = $grillTab[$i];
                }
                // placer le mot
                $counter = 0;
                for ($i = $posMotTableau, $iMax = strlen($mot); $i <= $iMax; $i = 16) {
                    $grillTab[$i] = $motGrille[$counter];
                    $counter++;
                }
                return true;
                break;

        }
    }


    public function verfierMotFranacaisValide($mot)
    {
        return true;
    }


    public function StringToArray($string)
    {
        $array = str_split($string);
        return str_ireplace($array, '-', '');
    }

    public function ArrayToString($array)
    {

    }


}
