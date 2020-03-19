<?php

namespace App\Policies;

use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any dashboards.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the dashboard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return mixed
     */
    public function view(User $user, Dashboard $dashboard)
    {
        //
    }

    /**
     * Determine whether the user can create dashboards.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the dashboard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return mixed
     */
    public function update(User $user, Dashboard $dashboard)
    {
        //
    }

    /**
     * Determine whether the user can delete the dashboard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return mixed
     */
    public function delete(User $user, Dashboard $dashboard)
    {
        if ($user->id == $dashboard->user_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the dashboard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return mixed
     */
    public function restore(User $user, Dashboard $dashboard)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the dashboard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return mixed
     */
    public function forceDelete(User $user, Dashboard $dashboard)
    {
        //
    }
}
