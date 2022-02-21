<?php

use App\Http\Controllers\JoueurController;
use App\Http\Controllers\PartieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// JoueurController rest api grouped under one controller

Route::controller(JoueurController::class)->prefix("v1")->group(static function () {
    Route::post("/inscrire", [JoueurController::class ,"inscrire"]);
    Route::get("/joueurs", [JoueurController::class ,"getJoueurs"]);
    Route::get("/joueur/{idJoueur}", [JoueurController::class ,"getJoueur"]);
    Route::get("/quitter/joueur/{idJoueur}",[JoueurController::class ,"quitPlayer"]);

});
Route::controller(PartieController::class)->prefix("v1")->group(static function () {
    Route::get("/partie/{idPartie}/joueurs",[PartieController::class ,"getJoueursByIdPartie"]);
    Route::get("/partie/joueur/{idJoueur}",[PartieController::class ,"getPartieByIdJoueur"]);
    Route::get("/partie/joueurs/joueur/{idJoueur}",[PartieController::class ,"getJoueursPartieByIdJoueur"]);
});



