<?php

namespace App\Http\Controllers;

use App\Repo\TicketRepository;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(TicketRepository $ticketRepository)
    {
        $tickets = $ticketRepository->getBuilder()->get()->transform($ticketRepository->formattedTicket());

        return Inertia::render('Reports/General', [
            'tickets' => $tickets,
        ]);
    }
}
