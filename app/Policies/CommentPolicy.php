<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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
    public function view(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): Response
    {
        return ($user->id === $comment->user_id) || ($user->is_admin && ($comment->user->is_admin === false || $comment->user->first_name === 'Deleted'))
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment)
    {
        return ($user->id === $comment->user_id) || ($user->is_admin && ($comment->user->is_admin === false || $comment->user->first_name === 'Deleted'))
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment)
    {
        //
    }
}
