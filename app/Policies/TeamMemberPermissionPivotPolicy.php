<?php

namespace App\Policies;

use App\Models\Teams\Authorization\TeamMemberPermissionPivot;
use App\Models\Users\User;
use Illuminate\Auth\Access\Response;

class TeamMemberPermissionPivotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('authorization.permission.teammember.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamMemberPermissionPivot $teamMemberPermissionPivot): bool
    {
        return $user->can('authorization.permission.teammember.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('authorization.permission.teammember.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamMemberPermissionPivot $teamMemberPermissionPivot): bool
    {
        return $user->can('authorization.permission.teammember.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamMemberPermissionPivot $teamMemberPermissionPivot): bool
    {
        return $user->can('authorization.permission.teammember.delete');
    }
}
