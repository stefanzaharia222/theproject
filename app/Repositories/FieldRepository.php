<?php

namespace App\Repositories;

use App\Interfaces\FieldInterface;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;

class FieldRepository implements FieldInterface
{
    protected $fieldElement = [
        'id',
        'tag',
        'code',
        'description',
        'class',
        'type',
        'name',
        'placeholder',
        'tooltip',
        'language',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fieldElement2 = [
        'fields.id',
        'tag',
        'code',
        'description',
        'class',
        'type',
        'name',
        'placeholder',
        'tooltip',
        'language',
        'fields.created_at',
        'fields.updated_at',
        'fields.deleted_at',
    ];

    /**
     * @param  int  $id
     * @return mixed
     */
    public function getFieldById(int $id): mixed
    {
        return Field::where('id', $id);
    }

    public function getFieldsByEntityId($fieldId)
    {
        try {
            $user = Auth::user();
            $entityName = $user->entity()->first()->name;
            return Field::where('id', $fieldId)
                ->whereHas('users.entity', function ($query) use ($entityName) {
                    $query->where('name', $entityName);
                })
                ->first();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getDeletedFieldsByEntityId($fieldId)
    {
        try {
            $user = Auth::user();
            $entityName = $user->entity()->first()->name;

            return Field::withTrashed()
                ->whereNotNull('deleted_at')
                ->where('id', $fieldId)
                ->whereHas('users.entity', function ($query) use ($entityName) {
                    $query->where('name', $entityName);
                })
                ->first();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getFields(): mixed
    {
        return Field::all();
    }

    /**
     * @return mixed
     */
    public function getFieldsDeleted(): mixed
    {
        return Field::withTrashed()->whereNotNull('deleted_at');
    }

    /**
     * @return mixed
     */
    public function getFieldSelect(): mixed
    {
        $fields = Field::all();

        foreach ($fields as $index => $field) {
            $fields[$index]->user = '';
            $fields[$index]->entity = '';

            $user = $field->users()->first();

            if (!empty($user)) {
                $fields[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $fields[$index]->entity = $entity->name;
                } else {
                    $fields[$index]->entity = '';
                }
            }
        }

        return $fields;
    }

    /**
     * @return mixed
     */
    public function getFieldDeletedSelect(): mixed
    {
        $fields = Field::withTrashed()->whereNotNull('deleted_at')->get();

        foreach ($fields as $index => $field) {
            $fields[$index]->user = '';
            $fields[$index]->entity = '';

            $user = $field->users()->first();

            if (!empty($user)) {
                $fields[$index]->user = $user->first_name . " " . $user->last_name;
                $entity = $user->entity()->first();

                if (!empty($entity)) {
                    $fields[$index]->entity = $entity->name;
                } else {
                    $fields[$index]->entity = '';
                }
            }
        }

        return $fields;
    }

    /**
     * @return mixed
     */
    public function getOwnedFieldSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedItems = $user->fields()->get();

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

        $standardItems = Field::where('type','standard')->get();

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

    public function getFieldEntity()
    {
        try {
            $user = Auth::user();
            $entity = $user->entity()->first();
            if ($entity) {
                $fields = Field::whereHas('users.entity', function ($query) use ($entity) {
                    $query->where('entity.id', $entity->id);
                })->get($this->fieldElement2);

                return $fields;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getOwnedFieldDeletedSelect(): mixed
    {
        $user = Auth::user();

        // Belong to the user
        $ownedItems = $user->fields()->withTrashed()->whereNotNull('fields.deleted_at')->get();

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

        $standardItems = Field::where('type','standard')->get();

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