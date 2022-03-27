<?php

namespace App\Repo;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class TicketRepository
{
    private Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function setUser(User $user): static
    {

        if (! $user->hasAnyRole(['moderator'])) {
            $this->builder->forTechnician($user->id);
        }

        return $this;
    }

    public function setFilters(array $filters = []): static
    {
        $this->builder->filter($filters);

        return $this;
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
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
                'technician_name' => optional($ticket)->technician->name
            ];
        };
    }
}
