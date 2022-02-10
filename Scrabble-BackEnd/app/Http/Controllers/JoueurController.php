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


    public function inscrire(Request $request)
    {
        $valid = $request->validate([
            "nom" => "required|max:50",
            "photo" => "mimes:jpg,bmp,png,jpeg",
            "partie" => "integer"
        ]);

        if ($valid) {
            $filename = "";
            if ($request->hasFile('photo')) {
                $filename = $request->file('photo')->store('joueurs', 'public');
                $request->photo = $filename;
            } else {
                $filename = 'public/profile.png';
            }
            $joueur = Joueur::create($request->all());
            return new  JoueurResource($joueur);
        } else {
            return Response()->json(['data' => 'invalid']);
        }


        /* $joueur = $request->validate($request,
             [
                 "nom" => "required|max:50",
                 "photo" => "mimes:jpg,bmp,png",
                 "partie" => "integer"
             ]
         );

         if ($joueur) {
             $j = Joueur::create($request->all());
             return Response()->json($j);

         } else {
             return Response()->json("erreur: impossible de se connecter verifier les info", 400);

         }*/


    }

    public function index()
    {
        return JoueurResource::collection(Joueur::all());

    }

}
