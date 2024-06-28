<?php

namespace App\Policies;

use App\Models\Authorization\AuthorizationType;
use App\Models\Users\User;
use Illuminate\Auth\Access\Response;

class AuthorizationTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('authorization.type.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AuthorizationType $authorizationType): bool
    {
        return $user->can('authorization.type.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('authorization.type.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AuthorizationType $authorizationType): bool
    {
        return $user->can('authorization.type.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AuthorizationType $authorizationType): bool
    {
        return $user->can('authorization.type.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AuthorizationType $authorizationType): bool
    {
        return $user->can('authorization.type.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AuthorizationType $authorizationType): bool
    {
        return $user->can('authorization.type.delete.force');
    }
}
