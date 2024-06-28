<?php

namespace App\Policies;

use App\Models\Teams\TeamInvitation;
use App\Models\Users\User;
use Illuminate\Auth\Access\Response;

class TeamInvitationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('team.invitation.view.any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamInvitation $teamInvitation): bool
    {
        return $user->can('team.invitation.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('team.invitation.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamInvitation $teamInvitation): bool
    {
        return $user->can('team.invitation.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamInvitation $teamInvitation): bool
    {
        return $user->can('team.invitation.delete');
    }
}
