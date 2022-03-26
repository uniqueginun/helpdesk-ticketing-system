<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticket;

    public string $notes;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, string $notes = '')
    {
        $this->ticket = $ticket;

        $this->notes = $notes;
    }
}
