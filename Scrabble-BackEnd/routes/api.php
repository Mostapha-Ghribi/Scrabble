<?php

use App\Http\Controllers\JoueurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// JoueurController rest api grouped under one controller

Route::controller(JoueurController::class)->prefix("v1")->group(static function () {
    Route::post("/inscrire", "inscrire");
    Route::get("/joueurs","getJoueurs");
    Route::get("/joueur/{idJoueur}","getJoueur");
});
Route::controller(PartieController::class)->prefix("v1")->group(static function () {
    Route::get("/partie/{idPartie}","getJoueursByIdPartie");
    Route::get("/partie/joueur/{idJoueur}","getJoueursPartieByIdPlayer");
});



