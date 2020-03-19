<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can edit models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function edit(User $user)
    {
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether user has client role
     *
     * @param User $user
     * @param User $client
     * @return mixed
     */
    public function isClient(User $user, User $client)
    {
        if ($client->hasRole(Role::CLIENT)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether user has manager role
     *
     * @param User $user
     * @param User $trainer
     * @return mixed
     */
    public function isTrainer(User $user, User $manager)
    {
        if ($manager->hasRole(Role::TRAINER)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether user has admin role
     *
     * @param User $user
     * @return mixed
     */
    public function isAdmin(User $user)
    {
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        } else {
            return false;
        }
    }

}
