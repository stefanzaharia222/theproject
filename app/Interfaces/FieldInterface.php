<?php

namespace App\Interfaces;

interface FieldInterface
{
    /**
     * @param  int  $id
     * @return mixed
     */
    public function getFieldById(int $id): mixed;

    /**
     * @return mixed
     */
    public function getFields(): mixed;

    /**
     * @return mixed
     */
    public function getFieldsDeleted(): mixed;

    /**
     * @return mixed
     */
    public function getFieldSelect(): mixed;

    /**
     * @return mixed
     */
    public function getFieldDeletedSelect(): mixed;

    /**
     * @return mixed
     */
    public function getOwnedFieldDeletedSelect(): mixed;
}