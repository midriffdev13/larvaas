<?php

namespace App\Policies;

use App\Models\Teams\Authorization\TeamMemberRolePivot;
use App\Models\Users\User;

class TeamMemberRolePivotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('authorization.role.teammember.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamMemberRolePivot $teamMemberRolePivot): bool
    {
        return $user->can('authorization.role.teammember.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('authorization.role.teammember.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamMemberRolePivot $teamMemberRolePivot): bool
    {
        return $user->can('authorization.role.teammember.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamMemberRolePivot $teamMemberRolePivot): bool
    {
        return $user->can('authorization.role.teammember.delete');
    }
}
