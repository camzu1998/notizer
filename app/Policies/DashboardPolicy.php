<?php

namespace App\Policies;

use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Dashboard $dashboard)
    {
        return $user->id === $dashboard->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Dashboard $dashboard)
    {
        return $user->id === $dashboard->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Dashboard $dashboard)
    {
        return $user->id === $dashboard->user_id && $dashboard->default === false;
    }
}
