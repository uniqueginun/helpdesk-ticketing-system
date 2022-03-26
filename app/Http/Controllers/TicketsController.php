<?php

namespace App\Http\Controllers;

use App\Events\TicketClosed;
use App\Events\TicketCreated;
use App\Http\Requests\TicketStoreRequest;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Throwable;

class TicketsController extends Controller
{
    private const COMPONENT_PREFIX = 'Tickets';

    public function __construct()
    {
        $this->middleware(['checkRole:admin|moderator'])->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        $moderator = $request->user()->hasAnyRole(['moderator']);

        $tickets = Ticket::query()
            ->when(! $moderator, fn ($query) => $query->forTechnician(Auth::id()))
            ->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString()
            ->through($this->formattedTicket());

        return Inertia::render(self::COMPONENT_PREFIX . '/Index', [
            'tickets' => $tickets,
            'ticketPriority' => Ticket::$ticketPriority,
            'deviceTypes' => Ticket::$deviceTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return InertiaResponse
     */
    public function create(): InertiaResponse
    {
        $technicians = User::technician()->latest()->get(['id', 'name']);

        return Inertia::render(self::COMPONENT_PREFIX . '/Create', [
            'ticketPriority' => Ticket::$ticketPriority,
            'deviceTypes' => Ticket::$deviceTypes,
            'technicians' => $technicians,
            'departments' => Department::all()
        ]);
    }

    public function store(TicketStoreRequest $request): RedirectResponse
    {

        DB::beginTransaction();

        try {

            event(new TicketCreated(Ticket::create([
                'uuid' => Str::uuid()->toString(),
                'ticket_type' => $request->ticket_type,
                'other_type_text' => $request->other_ticket_type,
                'details' => $request->details,
                'employee_name' => $request->employee_name,
                'department_id' => $request->department_id,
                'technician_id' => $request->technician,
                'priority' => $request->priority,
                'status' => Ticket::STATUS_NEW
            ])));

            DB::commit();

            return redirect()->back()->with('success', "تم إنشاء البلاغ بنجاح");

        } catch (Throwable $exception) {
            report($exception);
            DB::rollBack();
            return redirect()->back()->with('error', "حدثت مشكلة أثناء إنشاء البلاغ");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Ticket $ticket
     * @return InertiaResponse
     */
    public function show(Ticket $ticket): InertiaResponse
    {
        $ticket->load(['finishAction']);

        return Inertia::render(self::COMPONENT_PREFIX . '/Show', [
            'ticket' => $ticket,
        ]);
    }

    public function close(Request $request, Ticket $ticket): RedirectResponse
    {

        $request->validate([
            'notes' => 'required|string'
        ]);

        DB::beginTransaction();

        try {

            $ticket->update([
               'status' => Ticket::STATUS_CLOSED
            ]);

            event(new TicketClosed($ticket, $request->notes));

            DB::commit();

            return redirect()->route('tickets.show', $ticket->uuid)->with('success', "تم إنهاء البلاغ بنجاح");

        } catch (Throwable $exception) {
            report($exception);
            DB::rollBack();
            return redirect()->back()->with('error', "حدثت مشكلة أثناء إنهاء البلاغ");
        }
    }

    public function formattedTicket(): Closure
    {
        return function ($ticket) {
            return [
                'id' => $ticket->id,
                'uuid' => $ticket->uuid,
                'display_type' => $ticket->display_type,
                'details' => $ticket->details,
                'employee_name' => $ticket->employee_name,
                'priority' => $ticket->priority,
                'priority_name' => $ticket->priority_name,
                'status' => $ticket->status,
                'status_name' => $ticket->status_name,
                'creation_date' => $ticket->creation_date,
                'department_name' => $ticket->department->name,
                'technician_name' => $ticket->technician->name
            ];
        };
    }
}
