<?php

namespace App\Http\Controllers;

use App\Http\Resources\JoueurResource;
use App\Models\Joueur;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JoueurController extends Controller
{

    public function index()
    {
        return Joueur::all();
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


}
