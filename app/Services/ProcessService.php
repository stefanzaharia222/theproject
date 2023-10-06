<?php

namespace App\Services;

use App\Models\Process;
use App\Repositories\ProcessRepository;
use Illuminate\Support\Facades\Auth;

class ProcessService
{
    protected ProcessRepository $processRepository;

    public function __construct()
    {
        $this->processRepository = new ProcessRepository;
    }

    /**
     * Rearrange data for view
     *
     * @return array
     */
    public function getProcessData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $processData = $this->processRepository->getOwnedProcessSelect();

            $processDeletedData = $this->processRepository->getOwnedProcessDeletedSelect();
        } else {
            if ($user->hasRole('super-admin')) {
                $processData = $this->processRepository->getProcessSelect();

                $processDeletedData = $this->processRepository->getProcessDeletedSelect();
            }
        }

        return [
            'process' => $processData,
            'process_deleted' => $processDeletedData
        ];
    }

    public function getProcessEntityData()
    {
        $process = $this->processRepository->getProcessEntity();
        $processData = json_encode(array_map('array_values', $process->toArray()));

        return $processData;
    }

    /**
     * @param  array  $data
     */
    public function createProcess(array $data)
    {
        try {
            $user = Auth::user();


            $languages = [];

            foreach ($data['language'] as $lang => $values) {
                foreach ($values as $name => $value) {
                    if (count($values) > 1 && gettype($value) == 'array') {
                        $value = array_filter($value, function ($value) {
                            return $value !== null;
                        });
                        $languages[$lang][$name] = reset($value);
                    } else {
                        $languages[$lang][$name] = reset($values);
                    }
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

            (isset($data['tickets-selected'])) ? $tickets = json_encode($data['tickets-selected']) : $tickets = '';

            $user->process()->create([
                'name' => json_encode($orderLang['process-name']),
                'code' => $data['code'],
            ]);
            return redirect()->back()->with('success', 'Action was successful');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function trashProcessById(int $id): bool
    {
        try {
            return $this->processRepository->getProcessById($id)->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function restoreProcessById(int $id): bool
    {
        try {
            return $this->processRepository->getProcessById($id)->restore();
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
                            $this->trashProcessById($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreProcessById($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data) {
                            return $this->createProcess($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateProcess($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateProcess($data)
    {
        try {
            $entity = Process::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}