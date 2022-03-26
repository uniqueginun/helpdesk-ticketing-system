<?php

namespace App\Listeners;

use App\Events\TicketClosed;
use App\Models\TicketAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddCloseAction
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
     * @param  \App\Events\TicketClosed  $event
     * @return void
     */
    public function handle(TicketClosed $event)
    {
        $event->ticket->actions()->create([
            'action_type_id' => TicketAction::ACTION_CLOSED,
            'created_by' => auth()->id(),
            'action_notes' => $event->notes ?: ''
        ]);
    }
}
