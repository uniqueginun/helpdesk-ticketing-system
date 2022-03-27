<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function __invoke(Request $request): InertiaResponse
    {
        $component = $request->user()->user_role;

        $moderator = $request->user()->hasAnyRole(['moderator']);

        $tickets = $this->getTicketStatus($moderator);

        return Inertia::render('Dashboards/' . Str::ucfirst($component), [
            'ticket_status' => $tickets
        ]);
    }

    protected function getTicketStatus($moderator): array
    {
        $transformer = function ($ticket) {
            return [
                'status' => $ticket->status,
                'display_name' => Ticket::$ticketStatus[$ticket->status],
                'status_count' => $ticket->status_count
            ];
        };

        return DB::table('tickets')
            ->when(!$moderator, fn($query) => $query->where('technician_id', Auth::id()))
            ->select(DB::raw('status, count(*) as status_count'))
            ->groupBy('status')
            ->get()
            ->transform($transformer)->toArray();
    }
}
