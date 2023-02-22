<?php

namespace App\Policies;

use App\Models\Shopper;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopperPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shopper  $shopper
     * @return mixed
     */
    public function view(User $user, Shopper $shopper)
    {
        //
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
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shopper  $shopper
     * @return mixed
     */
    public function update(User $user, Shopper $shopper)
    {
        //
        return $user->id==$shopper->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shopper  $shopper
     * @return mixed
     */
    public function delete(User $user, Shopper $shopper)
    {
        //
        return $user->id==$shopper->id || $user->isAdministrator;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shopper  $shopper
     * @return mixed
     */
    public function restore(User $user, Shopper $shopper)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shopper  $shopper
     * @return mixed
     */
    public function forceDelete(User $user, Shopper $shopper)
    {
        //
    }
}
