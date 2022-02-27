<?php

namespace App\Http\Controllers;


use App\Events\getJoueurs;
use App\Models\Joueur;
use App\Models\Message;

use App\Models\Partie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
use stdClass;
use function Sodium\add;

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
    /*  ===================================================================================================================================== */

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
        $messages = Partie::find($partieId)->messages()
            ->where('partie', $partieId)
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
        return new JsonResponse($m);
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
     * @throws \Exception
     */

    public function creerMessage(Request $request)
    {
        $ligneArray = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o"];
        $posArray = ["h", "v"];
        $joueur = Joueur::find($request->envoyeur);
        $partie = Partie::find($request->partie);
        $contenu = trim($request->contenu);
        if ($contenu[0] !== '!') {
            $message = Message::create($request->all());
            event(new getJoueurs($partie->idPartie,$partie->typePartie));
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
        $ordre = $partie->nombreTours;


        if(($commande ==="placer" || $commande==="changer" || $commande==="passer") && ($ordre +1) %$partie->typePartie +1 !== $joueur->ordre){
            $messageCreated = Message::create(['contenu' => 'fait une commande impossible à réaliser', 'partie' =>  $partie->idPartie, 'envoyeur' => $joueur->idJoueur]);
            $messageCreated->increment('statutMessage');
            event(new getJoueurs($partie->idPartie,$partie->typePartie));
            return new JsonResponse([
                'message' => "$joueur->nom fait une commande impossible à réaliser",
            ], 404);
        }
        switch ($commande) {
            case 'placer' :
                $coordonnesContenu = substr($contenu, strpos($contenu, ' ') + 1);
                $coordonnes = substr($coordonnesContenu, 0, strpos($coordonnesContenu, ' '));
                $mot = substr($coordonnesContenu, strpos($coordonnesContenu, ' ') + 1);
                $ligne = $coordonnes[0];
                $coordonnes = substr($coordonnes, 1);
                $position = substr($coordonnes, -1);
                $coordonnes = substr($coordonnes, 0, -1);
                $colonne = intval($coordonnes);


                // tester si les coordonnes sont  invalide
                if (!in_array($ligne, $ligneArray, true) || !in_array($position, $posArray) || empty($mot) || ($colonne < 1 || $colonne > 15)) {
                    $messageCreated = Message::create(['contenu' => 'fait un erreur de syntaxe', 'partie' =>  $partie->idPartie, 'envoyeur' => $joueur->idJoueur]);
                    $messageCreated->increment('statutMessage');
                    event(new getJoueurs($partie->idPartie,$partie->typePartie));
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom fait un erreur de syntaxe",
                        'mot' => $mot,
                    ], 404);
                }
                // verifier l'inexistance des espace entres les characters d'un mot
                // la chaine doit etre alphabetique
                // la longeur du mot doit etre <= longeur de chevalet
                if (str_contains(trim($mot), ' ') ||
                    strlen(trim($mot)) < 2 ||
                    !ctype_alpha(trim($mot)) ||
                    !$this->verifierPostionMotValable($ligne, $colonne, $position, $mot) ||
                    !$this->verfierMotDansChevalet($mot, $joueur->chevalet, $partie->grille, $colonne, $ligne, $position, $ordre)) {
                    $messageCreated = Message::create(['contenu' => 'fait une commande impossible à réaliser', 'partie' =>  $partie->idPartie, 'envoyeur' => $joueur->idJoueur]);
                    $messageCreated->increment('statutMessage');
                    event(new getJoueurs($partie->idPartie,$partie->typePartie));
                    return new JsonResponse([
                        "nom" => $joueur->nom,
                        "partie" => $partie->idPartie,
                        'message' => "$joueur->nom fait une commande impossible à réaliser",
                        'mot' => $mot
                    ], 404);
                }
                $posMotTableau = (ord(strtoupper($ligne)) - ord('A')) * 15 + ($colonne - 1);
                $nouvelGrilleChaine = $partie->grille;
                $chaineGrille = '';
                $grillTab = $this->StringToArray($partie->grille);
                $imax = 0;
                $pas = 1;
                $reserve = $partie->reserve;
                $ResteMot = $mot;
                $Score = $joueur->score;
                $TM = 1;
                $DM = 1;
                $ScoreGrille=["TM","","","DL","","","","TM","","","","DL","","","TM","","DM","","","","TL","","","","TL","","","","DM","","","","DM","","","","DL","","DL","","","","DM","","","DL","","","DM","","","","DL","","","","DM","","","DL","","","","","DM","","","","","","DM","","","","","","TL","","","","TL","","","","TL","","","","TL","","","","DL","","","","DL","","DL","","","","DL","","","TM","","","DL","","","","","","","","DL","","","TM","","","DL","","","","DL","","DL","","","","DL","","","","TL","","","","TL","","","","TL","","","","TL","","","","","","DM","","","","","","DM","","","","","DL","","","DM","","","","DL","","","","DM","","","DL","","","DM","","","","DL","","DL","","","","DM","","","","DM","","","","TL","","","","TL","","","","DM","","TM","","","DL","","","","TM","","","","DL","","","TM"];

                switch ($position) {
                    case 'v' :
                        $imax =((ord(strtoupper($ligne)) - ord('A')) + strlen($mot) - 1) * 15 + ($colonne - 1);
                        $pas = 15;

                        break;
                    case 'h' :
                        $imax = $posMotTableau + strlen($mot);
                        break;
                }
                //return new JsonResponse($posMotTableau + strlen($mot));
                for ($i = $posMotTableau,$j=0; $i < $imax && $j<strlen($mot); $i+=$pas , $j++) {

                    $chaineGrille .= $grillTab[$i];
                    $nouvelGrilleChaine[$i] = $mot[$j];
                    if($ScoreGrille[$i] ==="DL"){
                        $Score += $this->valueLettre(strtoupper($nouvelGrilleChaine[$i])) *2;
                    }else if($ScoreGrille[$i] ==="TL"){
                        $Score += $this->valueLettre(strtoupper($nouvelGrilleChaine[$i])) *3;
                    }else if($ScoreGrille[$i] ==="TM"){
                        $Score += $this->valueLettre(strtoupper($nouvelGrilleChaine[$i]));
                        $TM *= 3;
                    }else if($ScoreGrille[$i] ==="DM"){
                        $Score += $this->valueLettre(strtoupper($nouvelGrilleChaine[$i]));
                        $DM *= 2;
                    }else{
                        $Score += $this->valueLettre(strtoupper($nouvelGrilleChaine[$i]));

                    }

                }
                $Score *= $TM;
                $Score *= $DM;


                $x = 0;
                while ($x < strlen($chaineGrille)) {
                    $char = $chaineGrille[$x];
                    if (str_contains($ResteMot, $char)) {
                        $posCharMot = strpos($ResteMot, $char);
                        $ResteMot = substr($ResteMot, 0, $posCharMot) . substr($ResteMot, $posCharMot + 1);
                        $x++;
                    }
                }
               // return new JsonResponse($ResteMot);
                // calculer bingo
                if(strlen($ResteMot) === 7){
                    $Score +=50;
                }

                $RestChevalet = $joueur->chevalet;
                $l = 0;
                while ($l < strlen($ResteMot)) {
                    $charRestMot = $ResteMot[$l];
                    if (ctype_upper($charRestMot)) {
                        $charRestMot = '*';
                    }
                    if (str_contains($RestChevalet, $charRestMot)) {
                        $posCharRestMot = strpos($RestChevalet, $charRestMot);
                        $RestChevalet = substr($RestChevalet, 0, $posCharRestMot) . substr($RestChevalet, $posCharRestMot + 1);
                        $l++;
                    }
                }
                for ($m = 0, $mMax = strlen($ResteMot); $m < $mMax; $m++) {
                    $RestChevalet .= $reserve[random_int(0, strlen($reserve) - 1)];
                    $strposRest = strpos($reserve, $RestChevalet[$m]);
                    $reserve = substr($reserve, 0, $strposRest) . substr($reserve, $strposRest + 1);
                }

                DB::table('parties')->where("idPartie", $partie->idPartie)
                    ->update(["grille" => strtolower($nouvelGrilleChaine), "reserve" => $reserve]);
                DB::table('parties')->where("idPartie", $partie->idPartie)
                    ->increment('nombreTours');
                DB::table("joueurs")->where("idJoueur", $joueur->idJoueur)->update(["chevalet" => $RestChevalet,'score'=>$Score]);

                event(new getJoueurs($partie->idPartie,$partie->typePartie));
                return new JsonResponse(['message'=>'successsssss']);

                break;
            case 'changer' :
                break;


            case 'passer' :
                $this->passerTour($joueur->idJoueur);
                break;
            case 'aider' :
                break;


            default :
                return new JsonResponse([
                    "nom" => $joueur->nom,
                    "partie" => $partie->idPartie,
                    'message' => "$joueur->nom fait une commande impossible à réaliser",
                    'mot' => $commande,
                ], 404);


        }


    }
    public function passerTour($idJoueur){
        $joueur = Joueur::find($idJoueur);
        $partie = Partie::find($joueur->partie);
        DB::table('parties')->where("idPartie", $partie->idPartie)
            ->increment('nombreTours');
        $partie2 = Partie::where('idPartie',$partie->idPartie)->first();
        event (new getJoueurs($partie2->idPartie,$partie2->typePartie));
        return new JsonResponse(['nombreTours'=> $partie2->nombreTours , 'typePartie'=>$partie2->typePartie]);
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


    public function StringToArray($string)
    {
        $array = str_split($string);
        for ($i = 0, $iMax = strlen($string); $i < $iMax; $i++) {
            if ($array[$i] === '-') {
                $array[$i] = '';
            }
        }
        return $array;
    }

    //? la chaine contient des -
    public function ArrayToString($array)
    {
        $chaine = "";
        for ($i = 0, $iMax = count($array); $i <= $iMax; $i++) {
            if ($array[$i] === "") {
                $chaine .= "-";
            } else {
                $chaine += $chaine[$i];
            }

        }
        return $chaine;
    }

    public function retournerMotGrille($mot, $grille, $colonne, $ligne, $pos)
    {
        $tabMot = str_split($mot);
        // convertir la grille en d'une chaine vers un tableau
        $grillTab = $this->StringToArray($grille);
        // retourner la position du mot dans le tableau (grille sous forme d'un tableau)
        $posMotTableau = (ord(strtoupper($ligne)) - ord('A')) * 15 + ($colonne - 1);
        // variable mot grille
        $TabmotGrille = [];
        $chaineGrille = '';
        switch ($pos) {
            case 'v' :
                for ($i = $posMotTableau, $iMax = strlen($mot); $i <= $iMax; $i += 16) {
                    $chaineGrille .= $grillTab[$i];
                }
                // ? verifier que la longeur mot < longeur chevalet
                $motCopie = $mot;
                $x = 0;
                while ($x < strlen($chaineGrille)) {
                    $char = $chaineGrille[$x];
                    if (str_contains($motCopie, $char)) {
                        $posCharMot = strpos($motCopie, $char);
                        $motCopie = substr($motCopie, 0, $posCharMot) . substr($motCopie, $posCharMot + 1);
                        $x++;
                    }
                }
                return $motCopie;
            case 'h' :
                for ($i = $posMotTableau, $iMax = $posMotTableau + strlen($mot); $i <= $iMax; $i++) {
                    $chaineGrille .= $grillTab[$i];
                }
                // ? verifier que la longeur mot < longeur chevalet
                $motCopie = $mot;
                $x = 0;
                while ($x < strlen($chaineGrille)) {
                    $char = $chaineGrille[$x];
                    if (str_contains($motCopie, $char)) {
                        $posCharMot = strpos($motCopie, $char);
                        $motCopie = substr($motCopie, 0, $posCharMot) . substr($motCopie, $posCharMot + 1);
                        $x++;
                    }
                }
                return $motCopie;

        }
    }

    //!  tester vaec h8 et ordre doit etre = 1 le premier vas jouer
    public function verfierMotDansChevalet($mot, $chevalet, $grille, $colonne, $ligne, $pos, $ordre): bool
    {
        $motGrille = [];
        $motAPlacer = str_split($mot);
        $resteMotGrille = '';
        $isOrderOne = true;
        // convertir la grille en d'une chaine vers un tableau
        $grillTab = $this->StringToArray($grille);
        // retourner la position du mot dans le tableau (grille sous forme d'un tableau)
        $posMotTableau = (ord(strtoupper($ligne)) - ord('A')) * 15 + ($colonne - 1);

        $chaineGrille = '';
        $motCopie = $mot;
        switch ($pos) {
            case 'v' :
                for ($i = $posMotTableau, $iMax = ((ord(strtoupper($ligne)) - ord('A')) + strlen($mot) - 1) * 15 + ($colonne - 1); $i <= $iMax; $i += 15) {
                    $chaineGrille .= $grillTab[$i];
                    array_push($motGrille,$grillTab[$i]);

                    if ($i === 112) {
                        $isOrderOne = false;
                    }
                }
                // ? verifier que la longeur mot < longeur chevalet

                $x = 0;
                while ($x < strlen($chaineGrille)) {
                    $char = $chaineGrille[$x];
                    if (str_contains($motCopie, $char)) {
                        $posCharMot = strpos($motCopie, $char);
                        $motCopie = substr($motCopie, 0, $posCharMot) . substr($motCopie, $posCharMot + 1);
                        $x++;
                    }
                }
                $resteMotGrille = $motCopie;
                break;
            case 'h' :
                for ($i = $posMotTableau, $iMax = $posMotTableau + strlen($mot); $i < $iMax; $i++) {
                    $chaineGrille .= $grillTab[$i];
                    array_push($motGrille,$grillTab[$i]);
                    if ($i === 112) {
                        $isOrderOne = false;
                    }
                }
                // ? verifier que la longeur mot < longeur chevalet

                $x = 0;
                while ($x < strlen($chaineGrille)) {
                    $char = $chaineGrille[$x];
                    if (str_contains($motCopie, $char)) {
                        $posCharMot = strpos($motCopie, $char);
                        $motCopie = substr($motCopie, 0, $posCharMot) . substr($motCopie, $posCharMot + 1);
                        $x++;
                    }
                }
                $resteMotGrille = $motCopie;
                break;

        }
        if(!$this->compareMotGrilleMot($motGrille,$motAPlacer)){
            return false;
        }



        // ***************************************************************************************
        //   $resteMotGrille = $this->retournerMotGrille($mot, $grille, $colonne, $ligne, $pos);
        $isEmplty = true;
        for ($y = 0;$y<225;$y++){
            if($grille[$y]!== '-'){
                $isEmplty = false;
            }
        }

        if ($isOrderOne && $isEmplty) {
            return false;
        }

        if ($resteMotGrille === '') {
            return false;
        }
        // ? verifier que la longeur mot < longeur chevalet
        $chevaletCopie = $chevalet;
        $x = 0;
        while ($x < strlen($resteMotGrille)) {
            $char = $resteMotGrille[$x];
            if (ctype_upper($char)) {
                $char = '*';
            }
            if (str_contains($chevaletCopie, $char)) {
                $posChar = strpos($chevaletCopie, $char);
                $chevaletCopie = substr($chevaletCopie, 0, $posChar) . substr($chevaletCopie, $posChar + 1);
                $x++;
            } else {
                return false;
            }
        }
        return true;
    }
    public function compareMotGrilleMot($motGrille,$mot) : bool{
        $i = 0;
        $valid = true;
        while($i<count($mot)&& $valid){
            if($motGrille[$i]===''){
                $i++;
            }else if($motGrille[$i] !== $mot[$i]){
                $valid = false;
            }else{
                $i++;
            }
        }
        return $valid;
    }
public function valueLettre($tile) : int {
    return match ($tile) {
        "A", "E", "I", "L", "N", "O", "R", "S", "T", "U" => 1,
        "D", "G", "M" => 2,
        "B", "C", "P" => 3,
        "F", "H", "V" => 4,
        "J", "Q" => 8,
        "K", "W", "X", "Y", "Z" => 10,
        default => 0,
    };
}

}
