<?php

namespace App\Policies;

use App\Models\Teams\Authorization\TeamPermissionPivot;
use App\Models\Users\User;

class TeamPermissionPivotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('authorization.permission.team.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamPermissionPivot $teamPermissionPivot): bool
    {
        return $user->can('authorization.permission.team.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('authorization.permission.team.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamPermissionPivot $teamPermissionPivot): bool
    {
        return $user->can('authorization.permission.team.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamPermissionPivot $teamPermissionPivot): bool
    {
        return $user->can('authorization.permission.team.delete');
    }
}
