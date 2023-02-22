<?php

namespace App\Policies;

use App\Models\ShipDetail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipDetailPolicy
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
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return mixed
     */
    public function view(User $user, ShipDetail $shipDetail)
    {
        //FALTA deixar o vendedor tmb ver

        return $user->id==$shipDetail->client->id;
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
        return $user->isClient;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return mixed
     */
    public function update(User $user, ShipDetail $shipDetail)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return mixed
     */
    public function delete(User $user, ShipDetail $shipDetail)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return mixed
     */
    public function restore(User $user, ShipDetail $shipDetail)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShipDetail  $shipDetail
     * @return mixed
     */
    public function forceDelete(User $user, ShipDetail $shipDetail)
    {
        //
        return false;
    }
}
