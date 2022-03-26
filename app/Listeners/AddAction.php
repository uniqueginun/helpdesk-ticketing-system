<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Models\Ticket;
use App\Models\TicketAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddAction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TicketCreated  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        $event->ticket->actions()->create([
            'action_type_id' => TicketAction::ACTION_CREATED,
            'created_by' => auth()->id()
        ]);

        $event->ticket->actions()->create([
            'action_type_id' => TicketAction::ACTION_ASSIGNED,
            'created_by' => auth()->id()
        ]);

        $event->ticket->update([
            'status' => Ticket::STATUS_ASSIGNED
        ]);
    }
}
