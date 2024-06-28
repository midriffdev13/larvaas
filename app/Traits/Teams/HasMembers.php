<?php

namespace App\Traits\Teams;

use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use App\Models\Teams\Team;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasMembers
{
    protected static $membersPivotTables = [
        Permission::class => 'team_member_permissions_pivot',
        Role::class => 'team_member_roles_pivot',
        Team::class => 'team_members_pivot',
    ];

    /**
     * Get all of the members that belong to the team.
     */
    public function members()
    {
        $className = get_class($this);

        if (isset(self::$membersPivotTables[$className])) {
            return $this->belongsToMany(User::class, self::$membersPivotTables[$className])->withTimestamps();
        }

        return null;
    }

    /**
     * Determine if the given user belongs to the team.
     */
    public function hasMember(mixed $user): bool
    {
        return $this->members->contains($user);
    }

    /**
     * Determine if the given email address belongs to a member on the team.
     */
    public function hasUserWithEmail(string $email): bool
    {
        return $this->members->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    public function getUserWithEmail(string $email): ?User
    {
        return $this->members->firstWhere('email', $email);
    }
}