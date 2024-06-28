<?php

namespace App\Policies;

use App\Models\Teams\Authorization\TeamRolePivot;
use App\Models\Users\User;

class TeamRolePivotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('authorization.role.team.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamRolePivot $teamRolePivot): bool
    {
        return $user->can('authorization.role.team.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('authorization.role.team.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamRolePivot $teamRolePivot): bool
    {
        return $user->can('authorization.role.team.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamRolePivot $teamRolePivot): bool
    {
        return $user->can('authorization.role.team.delete');
    }
}
