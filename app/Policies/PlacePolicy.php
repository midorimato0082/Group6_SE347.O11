<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlacePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role->name == 'Super Admin')
            return true;
        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Place $place)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->is_admin
        ? Response::allow()
        : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Place $place): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Place $place)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Place $place)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Place $place)
    {
        //
    }
}
