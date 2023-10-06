<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    /**
     * @param  int  $id
     * @return mixed
     */
    public function getTaskById(int $id): mixed
    {
        try {
            return Task::where('id', $id);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getTasks(): mixed
    {
        $tasks = Task::all();

        foreach ($tasks as $index => $task) {
            $tasks[$index]->user = '';
            $tasks[$index]->entity = '';

            $user = $task->first()->users()->first();

            if (!empty($user)) {
                $tasks[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $tasks[$index]->entity = $entity->name;
                } else {
                    $tasks[$index]->entity = '';
                }
            }
        }

        return $tasks;
    }

    /**
     * @return mixed
     */
    public function getTasksDeleted(): mixed
    {
        return Task::withTrashed()->whereNotNull('deleted_at');
    }

    /**
     * @return mixed
     */
    public function getTaskSelect(): mixed
    {
        $tasks = Task::all();

        foreach ($tasks as $index => $task) {
            $tasks[$index]->user = '';
            $tasks[$index]->entity = '';

            $user = $task->users()->first();

            if (!empty($user)) {
                $tasks[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $tasks[$index]->entity = $entity->name;
                } else {
                    $tasks[$index]->entity = '';
                }
            }
        }

        return $tasks;
    }

    /**
     * @return mixed
     */
    public function getTaskDeletedSelect(): mixed
    {
        $tasks = Task::withTrashed()->whereNotNull('deleted_at')->get();


        foreach ($tasks as $index => $task) {
            $tasks[$index]->user = '';
            $tasks[$index]->entity = '';

            $user = $task->users()->first();

            if (!empty($user)) {
                $tasks[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $tasks[$index]->entity = $entity->name;
                } else {
                    $tasks[$index]->entity = '';
                }
            }
        }

        return $tasks;
    }

    /**
     * @return mixed
     */
    public function getOwnedTaskSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedTasks = $user->tasks()->get();

        foreach ($ownedTasks as $index => $ownedTask) {
            $ownedTasks[$index]->user = '';
            $ownedTasks[$index]->entity = '';

            $user = $ownedTask->users()->first();

            if (!empty($user)) {
                $ownedTasks[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $ownedTasks[$index]->entity = $entity->name;
                } else {
                    $ownedTasks[$index]->entity = '';
                }
            }
        }

        $standardTasks = Task::where('type','standard')->get();

        $allTasks = $ownedTasks->merge($standardTasks);

        foreach ($allTasks as $index => $ownedTask) {
            if (isset($allTasks[$index]) && isset($standardTasks[$index])) {
                $standardTasks[$index]->user = '';
                $standardTasks[$index]->entity = '';

                $user = $ownedTask->users()->first();

                if (!empty($user)) {
                    $standardTasks[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardTasks[$index]->entity = $entity->name;
                    } else {
                        $standardTasks[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedTasks;
    }

    public function getTaskEntity()
    {
        try {
            $user = Auth::user();
            $entity = $user->entity()->first();
            if ($entity) {
                $tasks = Task::whereHas('users.entity', function ($query) use ($entity) {
                    $query->where('entities.id', $entity->id);
                })->get([
                    'tasks.id',
                    'tag',
                    'type',
                    'name',
                    'code',
                    'description',
                    'language',
                    'tooltip',
                    'placeholder',
                    'fields',
                    'tasks.created_at',
                    'tasks.updated_at',
                    'tasks.deleted_at',
                ]);

                return $tasks;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getOwnedTaskDeletedSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedTasks = $user->tasks()->withTrashed()->whereNotNull('tasks.deleted_at')->get();

        foreach ($ownedTasks as $index => $ownedTask) {
            $ownedTasks[$index]->user = '';
            $ownedTasks[$index]->entity = '';

            $user = $ownedTask->users()->first();

            if (!empty($user)) {
                $ownedTasks[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $ownedTasks[$index]->entity = $entity->name;
                } else {
                    $ownedTasks[$index]->entity = '';
                }
            }
        }

        $standardTasks = Task::where('type','standard')->get();

        $allTasks = $ownedTasks->merge($standardTasks);

        foreach ($allTasks as $index => $ownedTask) {
            if (isset($allTasks[$index]) && isset($standardTasks[$index])) {
                $standardTasks[$index]->user = '';
                $standardTasks[$index]->entity = '';

                $user = $ownedTask->users()->first();

                if (!empty($user)) {
                    $standardTasks[$index]->user = $user->first_name." ".$user->last_name;
                    $entity = $user->entity()->first();

                    if (!empty($entity)) {
                        $standardTasks[$index]->entity = $entity->name;
                    } else {
                        $standardTasks[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedTasks;
    }
}