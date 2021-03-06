<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class getJoueurs implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idPartie;
    public $typePartie;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idPartie,$typePartie)
    {
        $this->idPartie = $idPartie;
        $this->typePartie = $typePartie;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['player'];
    }
    public function broadcastAs() {
        return 'getJoueurs';
    }

}
