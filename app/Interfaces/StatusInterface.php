<?php

namespace App\Interfaces;

interface StatusInterface
{
    /**
     * @param  int  $id
     * @return mixed
     */
    public function getStatusById(int $id): mixed;

    /**
     * @return mixed
     */
    public function getStatus(): mixed;

    /**
     * @return mixed
     */
    public function getStatusDeleted(): mixed;

    /**
     * @return mixed
     */
    public function getStatusSelect(): mixed;

    /**
     * @return mixed
     */
    public function getStatusDeletedSelect(): mixed;

    /**
     * @return mixed
     */
    public function getOwnedStatusDeletedSelect(): mixed;
}