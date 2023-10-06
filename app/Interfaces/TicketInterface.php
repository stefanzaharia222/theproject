<?php

namespace App\Interfaces;

interface TicketInterface
{
    public function getTickets();
    public function getTicketById(int $id);
    public function getTicketsSelect();
    public function getTicketsDeleted();
    public function getTicketsDeletedSelect();
    public function getOwnedTicket();
    public function getOwnedTicketSelect();
    public function getOwnedTicketsDeleted();
    public function getOwnedTicketDeletedSelect();
}