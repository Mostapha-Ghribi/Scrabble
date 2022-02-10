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
        $valid = $request->validate([
            "nom" => "required|max:50",
            "photo" => "mimes:jpg,bmp,png,jpeg",
            "partie" => "integer"
        ]);

        $tousLesjoueurs = $this->index();
        $nomjoueur = $request->name;
        $validnom = true;
        $nom = Joueur::where('nom', $request->nom)->first();

        if ($nom == "" && $valid) {
            $filename = "";
            if ($request->hasFile('photo')) {
                $filename = $request->file('photo')->store('joueurs', 'public');
                $request->photo = $filename;
            } else {
                $filename = 'public/profile.png';
            }
            $joueur = Joueur::create($request->all());
            return new JoueurResource($joueur);
        } else {
            return Response()->json(['data' => 'invalid']);
        }


    }


}
