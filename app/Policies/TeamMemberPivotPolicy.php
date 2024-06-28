<?php

namespace App\Policies;

use App\Models\Teams\TeamMemberPivot;
use App\Models\Users\User;
use Illuminate\Auth\Access\Response;

class TeamMemberPivotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('team.member.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamMemberPivot $teamMemberPivot): bool
    {
        return $user->can('team.member.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('team.member.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamMemberPivot $teamMemberPivot): bool
    {
        return $user->can('team.member.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamMemberPivot $teamMemberPivot): bool
    {
        return $user->can('team.member.delete');
    }
}
