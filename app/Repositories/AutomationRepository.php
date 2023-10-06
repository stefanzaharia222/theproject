<?php

namespace App\Repositories;

use App\Models\Automation;
use Illuminate\Support\Facades\Auth;

class AutomationRepository
{
    protected $model;
    protected $user;
    private $ownedModels;
    private $ownedModelsDeleted;

    public function __construct ()
    {
        $this->model = new Automation();
        $this->user = Auth::check() ? Auth::user() : null;
        if ($this->user) {
            $this->ownedModels = Auth::user()->automations()->get();
            $this->ownedModelsDeleted = Auth::user()->automations()->withTrashed()->whereNotNull('automations.deleted_at')->get();
        }
    }

    public function getModelById(int $id): mixed
    {
        try {
            return $this->model->where('id', $id);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getAllItems(): mixed
    {
        $items = $this->model->all();

        foreach ($items as $index => $item) {
            $items[$index]->user = '';
            $items[$index]->entity = '';

            $this->user = $item->users()->first();

            if (!empty($this->user)) {
                $items[$index]->user = $this->user->first_name . " " . $this->user->last_name;
                $entity = $this->user->entity()->first();

                if (!empty($entity)) {
                    $items[$index]->entity = $entity->name;
                } else {
                    $items[$index]->entity = '';
                }
            }
        }

        return $items;
    }

    public function getDeletedModel(): mixed
    {
        $modelDeleted = $this->model->withTrashed()->whereNotNull('deleted_at')->get();

        foreach ($modelDeleted as $index => $model) {
            $modelDeleted[$index]->user = '';
            $modelDeleted[$index]->entity = '';

            $this->user = $model->users()->first();

            if (!empty($this->user)) {
                $modelDeleted[$index]->user = $this->user->first_name . " " . $this->user->last_name;
                $entity = $this->user->entity()->first();

                if (!empty($entity)) {
                    $modelDeleted[$index]->entity = $entity->name;
                } else {
                    $modelDeleted[$index]->entity = '';
                }
            }
        }

        return $modelDeleted;
    }

    public function getOwnedModel(): mixed
    {
        try {
            $ownedModels = Auth::user()->automations()->get();

            foreach ($ownedModels as $index => $ownedModel) {
                $ownedModels[$index]->user = '';
                $ownedModels[$index]->entity = '';

                $this->user = $ownedModel->users()->first();

                if (!empty($this->user)) {
                    $ownedModels[$index]->user = $this->user->first_name . " " . $this->user->last_name;
                    $entity = $this->user->entity()->first();

                    if (!empty($entity)) {
                        $ownedModels[$index]->entity = $entity->name;
                    } else {
                        $ownedModels[$index]->entity = '';
                    }
                }
            }

            $standardItems = $this->model->where('type','standard')->get();

            $allItems = $ownedModels->merge($standardItems);

            foreach ($allItems as $index => $ownedModel) {
                if (isset($allItems[$index]) && isset($standardItems[$index])) {
                    $standardItems[$index]->user = '';
                    $standardItems[$index]->entity = '';

                    $this->user = $ownedModel->users()->first();

                    if (!empty($this->user)) {
                        $standardItems[$index]->user = $this->user->first_name." ".$this->user->last_name;
                        $entity = $this->user->entity()->first();

                        if (!empty($entity)) {
                            $standardItems[$index]->entity = $entity->name;
                        } else {
                            $standardItems[$index]->entity = '';
                        }
                    }
                }
            }

            return $ownedModels;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getOwnedModelDeleted(): mixed
    {
        $this->user = Auth::user();
        $ownedModelsDeleted = Auth::user()->automations()->withTrashed()->whereNotNull('automations.deleted_at')->get();

        foreach ($ownedModelsDeleted as $index => $ownedModel) {
            $ownedModelsDeleted[$index]->user = '';
            $ownedModelsDeleted[$index]->entity = '';

            $this->user = $ownedModel->users()->first();

            if (!empty($this->user)) {
                $ownedModelsDeleted[$index]->user = $this->user->first_name . " " . $this->user->last_name;
                $entity = $this->user->entity()->first();

                if (!empty($entity)) {
                    $ownedModelsDeleted[$index]->entity = $entity->name;
                } else {
                    $this->ownedModelsDeleted[$index]->entity = '';
                }
            }
        }

        $standardItems = $this->model->where('type','standard')->get();

        $allItems = $ownedModelsDeleted->merge($standardItems);

        foreach ($allItems as $index => $ownedItem) {
            if (isset($allItems[$index]) && isset($standardItems[$index])) {
                $standardItems[$index]->user = '';
                $standardItems[$index]->entity = '';

                $this->user = $ownedItem->users()->first();

                if (!empty($this->user)) {
                    $standardItems[$index]->user = $this->user->first_name." ".$this->user->last_name;
                    $entity = $this->user->entity()->first();

                    if (!empty($entity)) {
                        $standardItems[$index]->entity = $entity->name;
                    } else {
                        $standardItems[$index]->entity = '';
                    }
                }
            }
        }

        return $ownedModelsDeleted;
    }
}