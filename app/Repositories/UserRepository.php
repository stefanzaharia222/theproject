<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserInterface
{
    public function getUserById($id)
    {
        return User::where('id', $id);
    }

    /**
     * @return mixed
     */
    public function getUsersSelect(): mixed
    {
        $user = Auth::user();

        $entity = new Entity();

        $entitiesId = $user->entity()->pluck('entity.id')->first();

        if ($user->hasRole('admin')) {
            $users = $entity
                ->find($entitiesId)
                ->users()
                ->where('users.id', '!=', $user->id)
                ->get([
                    'users.id',
                    'code',
                    'status',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'additional_contact_info',
                    'status',
                    'type',
                    'entity_id',
                    'email_verified_at',
                    'users.created_at',
                    'users.updated_at',
                    'users.deleted_at'
                ]);
        } else {
            $users = User::select('users.*', 'entity_user.entity_id')
                ->with('entity')
                ->where('users.id', '!=', $user->id)
                ->join('entity_user', 'users.id', '=', 'entity_user.user_id')
                ->select([
                    'users.id',
                    'code',
                    'status',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'additional_contact_info',
                    'status',
                    'type',
                    'entity_id',
                    'email_verified_at',
                    'users.created_at',
                    'users.updated_at',
                    'users.deleted_at',
                ])->get();
        }

        return $users;
    }

    /**
     * @return mixed
     */
    public function getUsersDeletedSelect(): mixed
    {
        $user = Auth::user();

        $entity = new Entity();

        $entitiesId = $user->entity()->pluck('entity.id')->first();

        if ($user->hasRole('admin')) {
            $users = $entity
                ->find($entitiesId)
                ->users()
                ->withTrashed()
                ->whereNotNull('users.deleted_at')
                ->get([
                    'users.id',
                    'code',
                    'status',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'additional_contact_info',
                    'status',
                    'type',
                    'entity_id',
                    'email_verified_at',
                    'users.created_at',
                    'users.updated_at',
                    'users.deleted_at'
                ]);
        } else {
            $users = User::withTrashed()
                ->whereNotNull('deleted_at')
                ->select('users.*', 'entity_user.entity_id')
                ->with('entity')
                ->join('entity_user', 'users.id', '=', 'entity_user.user_id')
                ->select([
                    'users.id',
                    'code',
                    'status',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'additional_contact_info',
                    'status',
                    'type',
                    'entity_id',
                    'email_verified_at',
                    'users.created_at',
                    'users.updated_at',
                    'users.deleted_at',
                ])->get();
        }

        return $users;
    }
}