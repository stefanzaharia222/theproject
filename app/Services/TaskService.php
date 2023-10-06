<?php

namespace App\Services;

use App\Models\Field;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    protected TaskRepository $tasksRepository;

    public function __construct()
    {
        $this->tasksRepository = new TaskRepository;
    }

    /**
     * Rearrange data for view
     *
     * @return array
     */
    public function getTaskData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $tasksData = $this->tasksRepository->getOwnedTaskSelect();

            $tasksDeletedData = $this->tasksRepository->getOwnedTaskDeletedSelect();
        } else {
            if ($user->hasRole('super-admin')) {
                $tasksData = $this->tasksRepository->getTaskSelect();

                $tasksData->transform(function ($task) {
                    if (!empty($task->fields)) {
                        $fieldNames = Field::whereIn('id', json_decode($task->fields))->pluck('name')->toArray();
                        $task->fields = implode('; ', $fieldNames);
                    }
                    return $task;
                });

                $tasksDeletedData = $this->tasksRepository->getTaskDeletedSelect();

                $tasksDeletedData->transform(function ($task) {
                    if (!empty($task->fields)) {
                        $fieldNames = Field::whereIn('id', json_decode($task->fields))->pluck('name')->toArray();
                        $task->fields = implode('; ', $fieldNames);
                    }
                    return $task;
                });
            }
        }

        return [
            'tasks' => $tasksData,
            'tasks_deleted' => $tasksDeletedData
        ];
    }

    public function getTaskEntityData()
    {
        $tasks = $this->tasksRepository->getTaskEntity();
        $tasksData = json_encode(array_map('array_values', $tasks->toArray()));

        return $tasksData;
    }

    /**
     * @param  array  $data
     */
    public function createTask(array $data)
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('super-admin')) {
                $entityName = '';
            } else {
                // get the name of the entity the user logged in is
                if (isset($user->entity()->first()->name)) {
                    $entityName = str_replace(' ', '_', $user->entity()->first()->name)  . '_';
                }
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

            (isset($data['fields-selected'])) ? $fields = json_encode($data['fields-selected']) : $fields = '';

            $user->tasks()->create([
                'name' => json_encode($orderLang['task-name']),
                'code' => $data['code'],
                'type' => $className,
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
            dd($e);
            return redirect()->back()->withInput()->with('failed', 'Action was failed.');
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function trashTaskById(int $id): bool
    {
        try {
            return $this->tasksRepository->getTaskById($id)->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function restoreTaskById(int $id): bool
    {
        try {
            return $this->tasksRepository->getTaskById($id)->restore();
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
                            $this->trashTaskById($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreTaskById($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data) {
                            return $this->createTask($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateTask($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateTask($data)
    {
        try {
            $entity = Task::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}