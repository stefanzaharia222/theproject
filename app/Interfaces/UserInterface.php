<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    /**
     * @return mixed
     */
    public function getUsersSelect(): mixed;

    /**
     * @return mixed
     */
    public function getUsersDeletedSelect(): mixed;
}