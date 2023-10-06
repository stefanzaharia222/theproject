<?php

namespace App\Http\Controllers;

use App\Services\EntityService;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $usersService;
    private EntityService $entityService;

    public function __construct()
    {
        $this->usersService = new UserService;
        $this->entityService = new EntityService();
    }

    public function usersList()
    {
        $data = $this->usersService->getUsersData();

        $entities = $this->entityService->getEntityData();

        return view('pages.users', [
            'users' => $data['users'],
            'users_deleted' => $data['users_deleted'],
            'entities' => json_decode($entities['entities'])
        ]);
    }
}
