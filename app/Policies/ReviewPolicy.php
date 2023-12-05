<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
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
    public function view(User $user, Review $review)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): Response
    {
        return $user->id === $review->admin_id
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): Response
    {
        return $user->id === $review->admin_id
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Review $review)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Review $review)
    {
        //
    }
}