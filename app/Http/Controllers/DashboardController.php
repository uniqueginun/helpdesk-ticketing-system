<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Repo\TicketRepository;
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

    public function index(Request $request): InertiaResponse
    {
        $component = $request->user()->user_role;

        $moderator = $request->user()->hasAnyRole(['moderator']);

        $tickets = $this->getTicketStatus($moderator);

        $technicians = User::technician()
            ->withCount('tickets')
            ->having('tickets_count', '>', 0)
            ->latest()
            ->get(['id', 'name'])
            ->transform(function ($tech) {
                return [
                    'id' => $tech->id,
                    'name' => $tech->name,
                ];
            });

        return Inertia::render('Dashboards/' . Str::ucfirst($component), [
            'ticket_status' => $tickets,
            'ticketPriority' => Ticket::$ticketPriority,
            'deviceTypes' => Ticket::$deviceTypes,
            'technicians' => $technicians,
            'departments' => Department::all()
        ]);
    }

    public function query(Request $request, TicketRepository $ticketRepository)
    {
        $tickets = $ticketRepository
            ->setUser($request->user())
            ->setFilters($request->only('priority', 'status', 'ticket_type', 'department_id'))
            ->getBuilder()
            ->get()
            ->transform($ticketRepository->formattedTicket());

        return Inertia::render('Reports/Index', [
            'tickets' => $tickets
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
