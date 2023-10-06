<?php

namespace App\Repositories;

use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class StatusRepository
{
    /**
     * @param  int  $id
     * @return mixed
     */
    public function getStatusById(int $id): mixed
    {
        try {
            return Status::where('id', $id);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getStatus(): mixed
    {
        return Status::all();
    }

    /**
     * @return mixed
     */
    public function getStatusDeleted(): mixed
    {
        return Status::withTrashed()->whereNotNull('deleted_at');
    }

    /**
     * @return mixed
     */
    public function getStatusSelect(): mixed
    {
        $statuses = Status::all();

        foreach ($statuses as $index => $status) {
            $statuses[$index]->user = '';
            $statuses[$index]->entity = '';

            $user = $status->users()->first();

            if (!empty($user)) {
                $statuses[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $statuses[$index]->entity = $entity->name;
                } else {
                    $statuses[$index]->entity = '';
                }
            }
        }

        return $statuses;
    }

    /**
     * @return mixed
     */
    public function getStatusDeletedSelect(): mixed
    {
        $statuses = Status::withTrashed()->whereNotNull('deleted_at')->get();

        foreach ($statuses as $index => $status) {
            $statuses[$index]->user = '';
            $statuses[$index]->entity = '';

            $user = $status->users()->first();

            if (!empty($user)) {
                $statuses[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $statuses[$index]->entity = $entity->name;
                } else {
                    $statuses[$index]->entity = '';
                }
            }
        }

        return $statuses;
    }

    /**
     * @return mixed
     */
    public function getOwnedStatusSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedItems = $user->status()->get();

        foreach ($ownedItems as $index => $ownedItem) {
            $ownedItems[$index]->user = '';
            $ownedItems[$index]->entity = '';

            $user = $ownedItem->users()->first();

            if (!empty($user)) {
                $ownedItems[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $ownedItems[$index]->entity = $entity->name;
                } else {
                    $ownedItems[$index]->entity = '';
                }
            }
        }

        $standardItem = Status::where('type','standard')->get();

        $allFields = $ownedItems->merge($standardItem);

        foreach ($allFields as $index => $ownedItem) {
            if (isset($allFields[$index]) && isset($standardItem[$index])) {
                $standardItem[$index]->user = '';
                $standardItem[$index]->entity = '';

                $user = $ownedItem->users()->first();

                if (!empty($user)) {
                    $standardItem[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardItem[$index]->entity = $entity->name;
                    } else {
                        $standardItem[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedItems;
    }

    public function getStatusEntity()
    {
        try {
            $user = Auth::user();
            $entity = $user->entity()->first();
            if ($entity) {
                $status = Status::whereHas('users.entity', function ($query) use ($entity) {
                    $query->where('entities.id', $entity->id);
                })->get([
                    'status.id',
                    'name',
                    'class',
                    'code',
                    'description',
                    'placeholder',
                    'tooltip',
                    'language',
                    'reason',
                    'tag',
                    'tickets',
                    'status.created_at',
                    'status.updated_at',
                    'status.deleted_at',
                ]);

                return $status;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getOwnedStatusDeletedSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedItems = $user->status()->withTrashed()->whereNotNull('status.deleted_at')->get();

        foreach ($ownedItems as $index => $ownedItem) {
            $ownedItems[$index]->user = '';
            $ownedItems[$index]->entity = '';

            $user = $ownedItem->users()->first();

            if (!empty($user)) {
                $ownedItems[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $ownedItems[$index]->entity = $entity->name;
                } else {
                    $ownedItems[$index]->entity = '';
                }
            }
        }

        $standardItem = Status::where('type','standard')->get();

        $allFields = $ownedItems->merge($standardItem);

        foreach ($allFields as $index => $ownedItem) {
            if (isset($allFields[$index]) && isset($standardItem[$index])) {
                $standardItem[$index]->user = '';
                $standardItem[$index]->entity = '';

                $user = $ownedItem->users()->first();

                if (!empty($user)) {
                    $standardItem[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardItem[$index]->entity = $entity->name;
                    } else {
                        $standardItem[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedItems;
    }
}