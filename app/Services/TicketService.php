<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    private TicketRepository $ticketRepository;

    public function __construct()
    {
        $this->ticketRepository = new TicketRepository;
    }

    /**
     * Rearrange data for view
     *
     * @return array
     */
    public function getTicketData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $ticketsData = $this->ticketRepository->getOwnedTicketSelect();

            $ticketsDeletedData = $this->ticketRepository->getOwnedTicketDeletedSelect();
        } else {
            if ($user->hasRole('super-admin')) {
                $ticketsData = $this->ticketRepository->getTicketsSelect();

                $ticketsData->transform(function ($task) {
                    if (!empty($task->fields)) {
                        $fieldNames = Ticket::whereIn('id', json_decode($task->fields))->pluck('name')->toArray();
                        $task->fields = implode('; ', $fieldNames);
                    }
                    return $task;
                });

                $ticketsDeletedData = $this->ticketRepository->getTicketsDeletedSelect();

                $ticketsDeletedData->transform(function ($task) {
                    if (!empty($task->fields)) {
                        $fieldNames = Ticket::whereIn('id', json_decode($task->fields))->pluck('name')->toArray();
                        $task->fields = implode('; ', $fieldNames);
                    }
                    return $task;
                });
            }
        }

        return [
            'tickets' => $ticketsData,
            'tickets_deleted' => $ticketsDeletedData
        ];
    }

    public function createTicket(array $data)
    {
        try {
            $user = Auth::user();

            if (Auth::user()->hasRole('super-admin')) {
                $entityName = '';
            } else {
                // get the name of the entity the user logged in is
                $entityName = str_replace(' ', '_', $user->entity()->first()->name).'_' ?? '';
            }
            // Check the role
            if ($user->hasRole('super-admin')) {
                $className = 'standard';
            } else {
                $className = 'custom';
            }

            $languages = [];

            foreach ($data['language'] as $lang => $values) {
                foreach ($values as $name => $value) {
                    $value = array_filter($value, function ($value) {
                        return $value !== null;
                    });

                    $languages[$lang][$name] = reset($value);
                }
            }

            $orderLang = [];

            foreach ($languages as $key => $value) {
                if ($key == 'us' || $key == 'gb') {
                    $key = 'en';
                }
                foreach ($value as $subKey => $subValue) {
                    if (!isset($orderLang[$subKey])) {
                        $orderLang[$subKey] = [];
                    }
                    $orderLang[$subKey][$key] = $subValue;
                }
            }

            $translations = [];

            foreach ($orderLang as $key => $value) {
                if (is_array($value)) {
                    // If the value is an array, extract the keys and merge them into $keyNames
                    $translations = array_merge($translations, array_keys($value));
                }
            }

            // Remove duplicate key names
            $translations = array_unique($translations);

            // Convert the array of key names into a single string
            $translationsString = implode(", ", $translations);

            (isset($data['fields-selected'])) ? $fields = json_encode($data['fields-selected']) : $fields = '';

            $user->tickets()->create([
                'name' => json_encode($orderLang['ticket-name']),
                'code' => $data['code'],
                'type' => $className,
                'class' => $data['class-ticket'],
                'description' => json_encode($orderLang['description']),
                'placeholder' => json_encode($orderLang['placeholder']),
                'tooltip' => json_encode($orderLang['tooltip']),
                'language' => $translationsString,
                'tag' => $className.'_'.$entityName.$data['code'],
                'fields' => $fields,
                'created_at' => Carbon::now()
            ]);

            return redirect()->back()->with('success', 'Action was successful');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput()->with('failed', 'Action was failed.');
        }
    }

    public function trashTicketById(int $id)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $this->ticketRepository->getTicketById($id)->delete();
        } else {
            // Should delete only owned fields
            if (!empty($this->ticketRepository->getTicketsByEntityId($id))) {
                return $this->ticketRepository->getTicketsByEntityId($id)->delete();
            } else {
                return redirect()->back()->with('failed', "You can't delete others fields!");
            }
        }
    }

    /**
     * @param  int  $id
     */
    public function restoreTicketById(int $id)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $this->ticketRepository->getTicketById($id)->restore();
        } else {
            // Should delete only owned fields
            if (!empty($this->ticketRepository->getDeletedTicketsByEntityId($id))) {
                return $this->ticketRepository->getDeletedTicketsByEntityId($id)->restore();
            } else {
                return redirect()->back()->with('failed', "You can't delete others fields!");
            }
        }
    }

    public function process($data)
    {
        try {
            if (isset($data['selected-rows-json'])) {
                $ids = json_decode($data['selected-rows-json']);

                switch ($data['form-action-select']) {
                    case 'bulk_delete':
                        foreach ($ids as $id) {
                            $this->trashTicketById($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreTicketById($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data['input']) {
                            return $this->createTicket($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateTicket($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateTicket($data)
    {
        try {
            $entity = Ticket::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}