<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    /**
     * @return array
     */
    public function getUsersData(): array
    {
        $usersData = $this->userRepository->getUsersSelect();

        $usersDeletedData = $this->userRepository->getUsersDeletedSelect();

        return [
            'users' => ($usersData),
            'users_deleted' => ($usersDeletedData)
        ];
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
                            $this->trashUserById($id);
                        }
                        break;

                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreEntityById($id);
                        }
                        break;
                    case 'change-entity':
                        if ($data['entity-id']) {
                            foreach ($ids as $userId) {
                                $this->changeUserEntity($userId, $data['entity-id']);
                            }
                        }
                        break;
                    case 'change-status':
                        foreach ($ids as $userId) {
                            $this->changeUserStatus($userId, $data['user-status']);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data) {
                            return $this->createUser($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateUser($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param  array  $data
     */
    public function createUser(array $data)
    {
        try {
            $user = User::create([
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => $data['e-mail'],
                'code' => $data['code'],
                'phone' => $data['phone'],
//            'additional_contact_info' => $data[''],
//            'status' => $data['status'],
                'type' => $data['user-kind'],
                'password' => Hash::make($data['password']),
            ]);

            if (!isset($data['entity-id']) && Auth::user()->hasRole('admin')) {
                $data['entity-id'] = Auth::user()->entity()->first()->id;
            }

            $user->email_verified_at = Carbon::now();
            $user->entity()->attach($data['entity-id']);
            $user->assignRole($data['user-kind']);
            $user->save();

            return redirect()->back()->with('success' , 'Action was successful');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function trashUserById(int $id): bool
    {
        try {
            $user = User::find($id);
            return $user->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return bool
     */
    public function restoreEntityById(int $id): bool
    {
        try {
            $user = User::withTrashed()->find($id);
            return $user->restore();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param $userId
     * @param $entitiesId
     * @return void
     */
    public function changeUserEntity($userId, $entitiesId)
    {
        try {
            $user = $this->userRepository->getUserById($userId)->first();
            $user->entity()->detach();
            $user->entity()->attach([$entitiesId]);
            $user->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function changeUserStatus($userId, $userStatus)
    {
        try {
            $user = $this->userRepository->getUserById($userId)->first();
            $user->update([
                'status' => $userStatus
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateUser($data)
    {
        try {
            $entity = User::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}