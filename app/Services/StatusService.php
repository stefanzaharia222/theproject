<?php

namespace App\Services;

use App\Models\Status;
use App\Models\StatusUserTicket;
use App\Models\Ticket;
use App\Repositories\StatusRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatusService
{
    protected StatusRepository $statusRepository;

    public function __construct()
    {
        $this->statusRepository = new StatusRepository;
    }

    /**
     * Rearrange data for view
     *
     * @return array
     */
    public function getStatusData(): array
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                $statusData = $this->statusRepository->getOwnedStatusSelect();

                $statusDeletedData = $this->statusRepository->getOwnedStatusDeletedSelect();
            } else {
                if ($user->hasRole('super-admin')) {
                    $statusData = $this->statusRepository->getStatusSelect();

                    // @TODO do the same thing to the owned of all type of items
                    $statusData->transform(function ($status) {
                        if (!empty($status->tickets)) {
                            $ticketName = Ticket::whereIn('id', json_decode($status->tickets))->pluck('name')->toArray();
                            $status->tickets = implode('; ', $ticketName);
                        }
                        return $status;
                    });

                    $statusDeletedData = $this->statusRepository->getStatusDeletedSelect();

                    $statusDeletedData->transform(function ($status) {
                        if (!empty($status->tickets)) {
                            $ticketName = Ticket::whereIn('id', json_decode($status->tickets))->pluck('name')->toArray();
                            $status->tickets = implode('; ', $ticketName);
                        }
                        return $status;
                    });
                }
            }

            return [
                'status' => $statusData,
                'status_deleted' => $statusDeletedData
            ];
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getStatusEntityData()
    {
        $status = $this->statusRepository->getStatusEntity();
        $statusData = json_encode(array_map('array_values', $status->toArray()));

        return $statusData;
    }

    /**
     * @param  array  $data
     */
    public function createStatus(array $data)
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
                if ($key == 'us' || $key == 'gb') $key = 'en';
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

            (isset($data['tickets-selected'])) ? $tickets = json_encode($data['tickets-selected']) : $tickets = '';

            $user->status()->create([
                'name' => json_encode($orderLang['name']),
                'code' => $data['code'],
                'class' => $data['class-status'],
                'type' => $className,
                'description' => json_encode($orderLang['description']),
                'placeholder' => json_encode($orderLang['placeholder']),
                'tooltip' => json_encode($orderLang['tooltip']),
                'language' => $translationsString,
                'reason' => $data['class-reason'] ?? '',
                'tag' => $className . '_'  .$entityName . $data['code'],
                'tickets' => $tickets,
                'created_at' => Carbon::now()
            ]);
            return redirect()->back()->with('success', 'Action was successful');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with('failed', 'Action was failed.');
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function trashStatusById(int $id): bool
    {
        try {
            return $this->statusRepository->getStatusById($id)->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function restoreStatusById(int $id): bool
    {
        try {
            return $this->statusRepository->getStatusById($id)->restore();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Add single or multiple rows
     *
     */
    public function process($data)
    {
        try {
            if (isset($data['selected-rows-json'])) {
                $ids = json_decode($data['selected-rows-json']);

                switch ($data['form-action-select']) {
                    case 'bulk_delete':
                        foreach ($ids as $id) {
                            $this->trashStatusById($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreStatusById($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data) {
                            return $this->createStatus($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateStatus($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateStatus($data)
    {
        try {
            $entity = Status::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}