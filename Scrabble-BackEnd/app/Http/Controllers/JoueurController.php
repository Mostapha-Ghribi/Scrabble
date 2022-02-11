<?php

namespace App\Http\Controllers;

use App\Http\Resources\JoueurResource;
use App\Models\Joueur;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;


class JoueurController extends Controller
{

    public function getJoueur($idJoueur)
    {
        $joueur = DB::table('joueurs')->where('idJoueur', "=", $idJoueur)->get();
        if (!empty(json_decode($joueur))) {
            return new JsonResource($joueur);
        }
        return Response()->json(["Erreur" => "le joueur n'existe pas"], 401);


    }


    public function inscrire(Request $request)
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

    public function getJoueurs()
    {
        return Joueur::all();
    }

}
