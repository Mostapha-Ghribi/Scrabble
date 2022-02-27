<?php

use App\Http\Controllers\JoueurController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PartieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(JoueurController::class)->prefix("v1")->group(static function () {
    Route::post("/inscrire", [JoueurController::class, "inscrire"]);
    Route::get("/joueurs", [JoueurController::class, "getJoueurs"]);
    Route::get("/joueur/{idJoueur}", [JoueurController::class, "getJoueur"]);
    Route::get("/quitter/joueur/{idJoueur}",[JoueurController::class ,"quitPlayer"]);
    Route::get("/quitter/partie/joueur/{idJoueur}",[JoueurController::class ,"quitPlayerPartie"]);
});

Route::controller(PartieController::class)->prefix("v1")->group(static function () {
    Route::get("/partie/{idPartie}/joueurs",[PartieController::class ,"getJoueursByIdPartie"]);
    Route::get("/partie/joueur/{idJoueur}",[PartieController::class ,"getPartieByIdJoueur"]);
    Route::get("/partie/joueurBind/{idJoueur}",[PartieController::class ,"getPartieByIdJoueurBind"]);
    Route::get("/addChevalet/partie/{idPartie}",[PartieController::class ,"InitChevaletAndReserve"]);
});
Route::controller(MessageController::class)->prefix("v1")->group(
    static function () {

        Route::get("/messages", [MessageController::class, 'index']);
        Route::get("/message/{idMessage}", [MessageController::class, 'getMessageById']);
        Route::get("/messages/joueur/{idJoueur}", [MessageController::class, 'getMessageByPlayerId']);
        Route::get("/messages/partie/{partieId}", [MessageController::class, 'getMessageByPartieId']);
        Route::get("/passerTour/{idJoueur}", [MessageController::class, 'passerTour']);
        Route::post("/message", [MessageController::class, 'creerMessage']);
    }

);

