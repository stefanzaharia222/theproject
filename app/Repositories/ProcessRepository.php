<?php

namespace App\Repositories;

use App\Models\Process;
use Illuminate\Support\Facades\Auth;

class ProcessRepository
{
    /**
     * @param  int  $id
     * @return mixed
     */
    public function getProcessById(int $id): mixed
    {
        try {
            return Process::where('id', $id);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getProcess(): mixed
    {
        return Process::all();
    }

    /**
     * @return mixed
     */
    public function getProcessDeleted(): mixed
    {
        return Process::withTrashed()->whereNotNull('deleted_at');
    }

    /**
     * @return mixed
     */
    public function getProcessSelect(): mixed
    {
        $processes = Process::all();

        foreach ($processes as $index => $process) {
            $processes[$index]->user = '';
            $processes[$index]->entity = '';

            $user = $process->users()->first();

            if (!empty($user)) {
                $processes[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $processes[$index]->entity = $entity->name;
                } else {
                    $processes[$index]->entity = '';
                }
            }
        }

        return $processes;
    }

    /**
     * @return mixed
     */
    public function getProcessDeletedSelect(): mixed
    {
        $processes = Process::withTrashed()->whereNotNull('deleted_at')->get();

        foreach ($processes as $index => $process) {
            $processes[$index]->user = '';
            $processes[$index]->entity = '';

            $user = $process->users()->first();

            if (!empty($user)) {
                $processes[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $processes[$index]->entity = $entity->name;
                } else {
                    $processes[$index]->entity = '';
                }
            }
        }

        return $processes;
    }

    /**
     * @return mixed
     */
    public function getOwnedProcessSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedItems = $user->process()->get();

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

        $standardItems = Process::where('type','standard')->get();

        $allItems = $ownedItems->merge($standardItems);

        foreach ($allItems as $index => $ownedItem) {
            if (isset($allItems[$index]) && isset($standardItems[$index])) {
                $standardItems[$index]->user = '';
                $standardItems[$index]->entity = '';

                $user = $ownedItem->users()->first();

                if (!empty($user)) {
                    $standardItems[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardItems[$index]->entity = $entity->name;
                    } else {
                        $standardItems[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedItems;
    }

    public function getProcessEntity()
    {
        try {
            $user = Auth::user();
            $entity = $user->entity()->first();
            if ($entity) {
                $process = Process::whereHas('users.entity', function ($query) use ($entity) {
                    $query->where('entities.id', $entity->id);
                })->get([
                    'process.id',
                    'tag',
                    'name',
                    'process.created_at',
                    'process.updated_at',
                    'process.deleted_at',
                ]);

                return $process;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getOwnedProcessDeletedSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedItems = $user->process()->withTrashed()->whereNotNull('process.deleted_at')->get();

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

        $standardItems = Process::where('type','standard')->get();

        $allItems = $ownedItems->merge($standardItems);

        foreach ($allItems as $index => $ownedItem) {
            if (isset($allItems[$index]) && isset($standardItems[$index])) {
                $standardItems[$index]->user = '';
                $standardItems[$index]->entity = '';

                $user = $ownedItem->users()->first();

                if (!empty($user)) {
                    $standardItems[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardItems[$index]->entity = $entity->name;
                    } else {
                        $standardItems[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedItems;
    }
}