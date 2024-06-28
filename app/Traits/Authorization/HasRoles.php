<?php

namespace App\Traits\Authorization;

use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use App\Models\Teams\Team;
use App\Models\Teams\TeamMemberPivot;
use App\Models\Users\User;

trait HasRoles
{
    protected static $rolesPivotTables = [
        User::class => 'user_roles_pivot',
        Team::class => 'team_roles_pivot',
        TeamMemberPivot::class => 'team_member_roles_pivot',
        Permission::class => 'role_permissions_pivot',
    ];

    public function roles()
    {
        $className = get_class($this);
        
        if (isset(self::$rolesPivotTables[$className])) {
            return $this->belongsToMany(Role::class, self::$rolesPivotTables[$className])->withTimestamps();
        }

        return null;
    }

    public function hasRole($role)
    {
        return $this->roles()->where('role', $role)->exists();
    }

    public function assignRole($role)
    {
        $this->roles()->attach($role);
    }

    public function removeRole($role)
    {
        $this->roles()->detach($role);
    }

    public function syncRoles($roles)
    {
        $this->roles()->sync($roles);
    }

    public function getRoleNames()
    {
        return $this->roles()->pluck('role')->toArray();
    }
}