<?php

namespace App\Http\Controllers;

use App\Services\SelectOptionService;
use App\Services\StatusService;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    private StatusService $fieldService;
    private SelectOptionService $selectOption;
    private TicketService $ticketService;

    public function __construct()
    {
        $this->fieldService = new StatusService;
        $this->selectOption = new SelectOptionService;
        $this->ticketService = new TicketService();
    }

    public function statusList()
    {
        try {
            $status = $this->fieldService->getStatusData();
            $fieldSelectOption = $this->selectOption->getSOStatus();
            if (Auth::user()->hasRole('admin')) {
                // @TODO - allow to see only owned data of the entity!
                $tickets = $this->ticketService->getTicketData();
            }
            if (Auth::user()->hasRole('super-admin')) {
                $tickets = $this->ticketService->getTicketData();
            }

            return view('pages.status', [
                'status' => $status['status'],
                'status_deleted' => $status['status_deleted'],
                'select_option' => $fieldSelectOption,
                'tickets' => $tickets
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
