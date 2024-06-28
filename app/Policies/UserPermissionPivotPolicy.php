<?php

namespace App\Policies;

use App\Models\Users\Authorization\UserPermissionPivot;
use App\Models\Users\User;

class UserPermissionPivotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('authorization.permission.user.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserPermissionPivot $userPermissionPivot): bool
    {
        return $user->can('authorization.permission.user.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('authorization.permission.user.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserPermissionPivot $userPermissionPivot): bool
    {
        return $user->can('authorization.permission.user.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserPermissionPivot $userPermissionPivot): bool
    {
        return $user->can('authorization.permission.user.delete');
    }
}