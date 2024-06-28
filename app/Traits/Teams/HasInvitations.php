<?php

namespace App\Traits\Teams;

use App\Models\Teams\TeamInvitation;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasInvitations
{
    /**
     * Get the invitations that the team has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations() : HasMany
    {
        return $this->hasMany(TeamInvitation::class, 'team_id');
    }

    /**
     * Determine if the given email address belongs to an invitation of the team.
     */
    public function hasInvitationWithEmail(string $email): bool
    {
        return $this->invitations->contains(function ($invitation) use ($email) {
            return $invitation->email === $email;
        });
    }
}