<?php

namespace App\Interfaces;

interface EntityInterface
{
    /**
     * @param  int  $id
     * @return mixed
     */
    public function getEntityById(int $id): mixed;

    /**
     * @return mixed
     */
    public function getEntities(): mixed;

    /**
     * @return mixed
     */
    public function getEntitiesDeleted(): mixed;

    /**
     * @return mixed
     */
    public function getEntitySelect(): mixed;

    /**
     * @return mixed
     */
    public function getEntityDeletedSelect(): mixed;
}