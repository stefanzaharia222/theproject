<?php

namespace App\Http\Controllers;

use App\Services\FieldService;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    private TicketService $ticketService;
    private FieldService $fieldService;

    public function __construct()
    {
        $this->ticketService = new TicketService;
        $this->fieldService = new FieldService();
    }

    public function ticketList()
    {
        $fields = [];

        $tickets = $this->ticketService->getTicketData();

        if (Auth::user()->hasRole('admin')) {
            // @TODO - allow to see only owned data of the entity!
            $fields = $this->fieldService->getFieldData();
        }
        if (Auth::user()->hasRole('super-admin')) {
            $fields = $this->fieldService->getFieldData();
        }

        return view('pages.tickets', [
            'tickets' => $tickets['tickets'],
            'tickets_deleted' => $tickets['tickets_deleted'],
            'fields' => $fields
        ]);
    }
}
