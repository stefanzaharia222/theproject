<?php

namespace App\Services;

use App\Repositories\AssignmentRepository;
use Illuminate\Support\Facades\Auth;

class AssignmentService
{
    private $repository;
    private $nameInput;
    private $nameSelectedInput;
    protected $user;

    public function __construct()
    {
        $this->repository = new AssignmentRepository();
        $this->nameSelectedInput  = 'tickets-selected';
        $this->nameInput  = 'role-name';
        $this->user = Auth::user();
    }

    public function process($data)
    {
        try {
            if (isset($data['selected-rows-json'])) {
                $ids = json_decode($data['selected-rows-json']);

                switch ($data['form-action-select']) {
                    case 'bulk_delete':
                        foreach ($ids as $id) {
                            $this->trash($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restore($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data) {
                            return $this->create($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            $finalInput = array_filter($data['input'], function ($item) {
                                return !empty($item);
                            });

                            return $this->update($finalInput);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getData(): array
    {
        if (Auth::user()->hasRole('admin')) {
            $data = $this->repository->getOwnedModel();

            $dataDeleted = $this->repository->getOwnedModelDeleted();
        } else {
            if (Auth::user()->hasRole('super-admin')) {
                $data = $this->repository->getAllItems();

                $dataDeleted = $this->repository->getDeletedModel();
            }
        }

        return [
            'data' => $data,
            'data_deleted' => $dataDeleted
        ];
    }

    public function create(array $data)
    {
        try {
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

            (isset($data[$this->nameSelectedInput])) ? $items = json_encode($data[$this->nameSelectedInput]) : $items = '';

            $this->user->assignments()->create([
                'name' => json_encode($orderLang[$this->nameInput]),
                'code' => $data['code'],
            ]);
            return redirect()->back()->with('success', 'Action was successful');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function trash(int $id): bool
    {
        try {
            return $this->repository->getModelById($id)->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function restore(int $id): bool
    {
        try {
            return $this->repository->getModelById($id)->restore();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update($data)
    {
        try {
            $dateFields = ['created_at', 'updated_at', 'deleted_at'];

            foreach ($data as $name => $item) {
                if (in_array($name, $dateFields)) {
                    $data[$name] = date('Y-m-d H:i:s', strtotime($data[$name]));
                }
            }

            return $this->repository->getModelById($data['id'])->update($data);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}