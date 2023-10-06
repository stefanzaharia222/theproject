<?php

namespace App\Repositories;

use App\Interfaces\EntityInterface;
use App\Models\Entity;

class EntityRepository implements EntityInterface
{
    public function getEntityById(int $id): mixed
    {
        return Entity::find($id);
    }

    public function getEntityWithTrashedById(int $id): mixed
    {
        return Entity::withTrashed()->find($id);
    }

    public function getEntities(): mixed
    {
        return Entity::all();
    }

    public function getEntitiesDeleted(): mixed
    {
        return Entity::withTrashed()->whereNotNull('deleted_at');
    }

    public function getEntitySelect(): mixed
    {
        return Entity::select([
            'id',
            'tag',
            'name',
            'code',
            'description',
            'address',
            'created_at',
            'updated_at',
            'deleted_at',
        ])->get();
    }

    public function getEntityDeletedSelect(): mixed
    {
        return $this->getEntitiesDeleted()->get([
            'id',
            'tag',
            'name',
            'code',
            'description',
            'address',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }
}