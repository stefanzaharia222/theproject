<?php

namespace App\Repositories;

use App\Interfaces\TicketInterface;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketRepository implements TicketInterface
{
    protected $ticketEl = [
        'id',
        'tag',
        'class',
        'type',
        'name',
        'code',
        'description',
        'language',
        'tooltip',
        'placeholder',
        'fields',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $ticketEl2 = [
        'tickets.id',
        'tag',
        'class',
        'type',
        'name',
        'code',
        'description',
        'language',
        'tooltip',
        'placeholder',
        'fields',
        'tickets.created_at',
        'tickets.updated_at',
        'tickets.deleted_at',
    ];
    public function getTickets()
    {
        return Ticket::all();
    }

    public function getTicketById(int $id)
    {
        return Ticket::where('id', $id);
    }

    public function getTicketsByEntityId($id)
    {
        try {
            $user = Auth::user();
            $entityName = $user->entity()->first()->name;
            return Ticket::where('id', $id)
                ->whereHas('users.entity', function ($query) use ($entityName) {
                    $query->where('name', $entityName);
                })
                ->first();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getDeletedTicketsByEntityId($id)
    {
        try {
            $user = Auth::user();
            $entityName = $user->entity()->first()->name;

            return Ticket::withTrashed()
                ->whereNotNull('deleted_at')
                ->where('id', $id)
                ->whereHas('users.entity', function ($query) use ($entityName) {
                    $query->where('name', $entityName);
                })
                ->first();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getTicketsSelect()
    {
        $tickets = Ticket::all();

        foreach ($tickets as $index => $ticket) {
            $tickets[$index]->user = '';
            $tickets[$index]->entity = '';

            $user = $ticket->first()->users()->first();

            if (!empty($user)) {
                $tickets[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $tickets[$index]->entity = $entity->name;
                } else {
                    $tickets[$index]->entity = '';
                }
            }
        }

        return $tickets;
    }

    public function getTicketsDeleted()
    {
        $tickets = Ticket::withTrashed()->whereNotNull('deleted_at')->get();

        foreach ($tickets as $index => $ticket) {
            $tickets[$index]->user = '';
            $tickets[$index]->entity = '';

            $user = $ticket->first()->users()->first();

            if (!empty($user)) {
                $tickets[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $tickets[$index]->entity = $entity->name;
                } else {
                    $tickets[$index]->entity = '';
                }
            }
        }

        return $tickets;
    }

    public function getTicketsDeletedSelect()
    {

        $tickets = Ticket::withTrashed()->whereNotNull('deleted_at')->get();

        foreach ($tickets as $index => $ticket) {
            $tickets[$index]->user = '';
            $tickets[$index]->entity = '';

            $user = $ticket->first()->users()->first();

            if (!empty($user)) {
                $tickets[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $tickets[$index]->entity = $entity->name;
                } else {
                    $tickets[$index]->entity = '';
                }
            }
        }

        return $tickets;
    }

    public function getOwnedTicket()
    {

    }

    public function getOwnedTicketSelect()
    {
        $user = Auth::user();

        // Belong to the user
        $ownedTickets = $user->tickets()->get();

        foreach ($ownedTickets as $index => $ownedTicket) {
            $ownedTickets[$index]->user = '';
            $ownedTickets[$index]->entity = '';

            $user = $ownedTicket->users()->first();

            if (!empty($user)) {
                $ownedTickets[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $ownedTickets[$index]->entity = $entity->name;
                } else {
                    $ownedTickets[$index]->entity = '';
                }
            }
        }

        $standardTickets = Ticket::where('type','standard')->get();

        $allTickets = $ownedTickets->merge($standardTickets);

        foreach ($allTickets as $index => $ownedTicket) {
            if (isset($allTickets[$index]) && isset($standardTickets[$index])) {
                $standardTickets[$index]->user = '';
                $standardTickets[$index]->entity = '';

                $user = $ownedTicket->users()->first();

                if (!empty($user)) {
                    $standardTickets[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardTickets[$index]->entity = $entity->name;
                    } else {
                        $standardTickets[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedTickets;
    }

    public function getOwnedTicketsDeleted()
    {
        try {
            return Ticket::withTrashed()
                ->whereNotNull('deleted_at')
                ->hereHas('users.entity', function ($query) {
                $query->where('entities.id', 2);
            })->get($this->ticketEl2);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getOwnedTicketDeletedSelect()
    {
        $user = Auth::user();

        // Belong to the user
        $ownedTickets = $user->tickets()->withTrashed()->whereNotNull('tickets.deleted_at')->get();

        foreach ($ownedTickets as $index => $ownedTicket) {
            $ownedTickets[$index]->user = '';
            $ownedTickets[$index]->entity = '';

            $user = $ownedTicket->users()->first();

            if (!empty($user)) {
                $ownedTickets[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $ownedTickets[$index]->entity = $entity->name;
                } else {
                    $ownedTickets[$index]->entity = '';
                }
            }
        }

        $standardTickets = Ticket::where('type','standard')->get();

        $allTickets = $ownedTickets->merge($standardTickets);

        foreach ($allTickets as $index => $ownedTicket) {
            if (isset($allTickets[$index]) && isset($standardTickets[$index])) {
                $standardTickets[$index]->user = '';
                $standardTickets[$index]->entity = '';

                $user = $ownedTicket->users()->first();

                if (!empty($user)) {
                    $standardTickets[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardTickets[$index]->entity = $entity->name;
                    } else {
                        $standardTickets[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedTickets;
    }
}