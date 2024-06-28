<?php

namespace App\Traits\Users;

use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use App\Models\Users\User;
use App\Models\Teams\Team;

trait HasUsers
{
    protected static $usersPivotTables = [
        Permission::class => 'user_permissions_pivot',
        Role::class => 'user_roles_pivot',
        Team::class => 'team_members_pivot',
    ];

    public function users()
    {
        $className = get_class($this);

        if (isset(self::$usersPivotTables[$className])) {
            return $this->belongsToMany(User::class, self::$usersPivotTables[$className]);
        }

        return null;
    }

    public function hasUser($user)
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    public function addUser($user)
    {
        return $this->users()->attach($user);
    }

    public function removeUser($user)
    {
        return $this->users()->detach($user);
    }

    public function syncUsers($users)
    {
        return $this->users()->sync($users);
    }
}