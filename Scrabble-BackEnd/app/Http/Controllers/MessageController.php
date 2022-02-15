<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

class MessageController extends Controller
{
    /**
     * retourner tous les message  triée par dateCreation

     */
    public function index()
    {
        return Message::latest('dateCreation')->get();
    }



}
