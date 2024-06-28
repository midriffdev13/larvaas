<?php

namespace App\Traits\Authorization;

use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use App\Models\Teams\Team;
use App\Models\Teams\TeamMemberPivot;
use App\Models\Users\User;

trait HasPermissions
{
    protected static $permissionsPivotTables = [
        User::class => 'user_permissions_pivot',
        Team::class => 'team_permissions_pivot',
        TeamMemberPivot::class => 'team_member_permissions_pivot',
        Role::class => 'role_permissions_pivot',
    ];

    public function permissions()
    {
        $className = get_class($this);
        
        if (isset(self::$permissionsPivotTables[$className])) {
            return $this->belongsToMany(Permission::class, self::$permissionsPivotTables[$className])->withTimestamps();
        }

        return null;
    }

    public function can($permission, $teamId = null)
    {
        $perms = $this->allPermissions();

        if ($teamId) {
            $member = TeamMemberPivot::where('team_id', $teamId)->where('user_id', $this->id)->first();
            $memberPerms = $member->allPermissions();

            foreach ($memberPerms as $perm) {
                if ($this->hasPermission($perm, $permission)) {
                    return true;
                }
            }
        } else {
            foreach ($perms as $perm) {
                if ($this->hasPermission($perm, $permission)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if the given requiredPermission is accessible under the given assignedPermission.
     *
     * @param string $assignedPermission The permission assigned to the user, team, team member, or role.
     * @param string $requiredPermission The permission that is being checked for access.
     * @return bool
     */
    function hasPermission($assignedPermission, $requiredPermission) {
        // Check for an exact match first.
        if ($assignedPermission === $requiredPermission) {
            return true;
        }

        // Split the permissions into parts based on the dot (.)
        $assignedParts = explode('.', $assignedPermission);
        $requiredParts = explode('.', $requiredPermission);

        $assignedIndex = 0;
        $requiredIndex = 0;

        while ($assignedIndex < count($assignedParts) && $requiredIndex < count($requiredParts)) {
            if ($assignedParts[$assignedIndex] === '*') {
                // If the next part in assignedPermission is also a wildcard, proceed to the next part.
                if (isset($assignedParts[$assignedIndex + 1]) && $assignedParts[$assignedIndex + 1] === '*') {
                    $assignedIndex++;
                    continue;
                }

                // If there is no next part, or if the next part matches, return true.
                if (!isset($assignedParts[$assignedIndex + 1]) || $assignedParts[$assignedIndex + 1] === $requiredParts[$requiredIndex]) {
                    return true;
                }

                // Proceed to the next part in requiredPermission.
                $requiredIndex++;
            } elseif ($assignedParts[$assignedIndex] === $requiredParts[$requiredIndex]) {
                $assignedIndex++;
                $requiredIndex++;
            } else {
                return false;
            }
        }

        // Check if all parts of the assignedPermission match with requiredPermission.
        return $assignedIndex === count($assignedParts) && $requiredIndex === count($requiredParts);
    }

    public function hasAnyPermission($assignedPermission, $requiredPermissions)
    {
        foreach ($requiredPermissions as $requiredPermission) {
            if ($this->hasPermission($assignedPermission, $requiredPermission)) {
                return true;
            }
        }

        return false;
    }

    public function hasAllPermissions($assignedPermission, $requiredPermissions)
    {
        foreach ($requiredPermissions as $requiredPermission) {
            if (!$this->hasPermission($assignedPermission, $requiredPermission)) {
                return false;
            }
        }

        return true;
    }

    public function hasDirectPermission($permission)
    {
        return $this->permissions->contains('name', $permission);
    }

    public function assignPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function removePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function syncPermissions($permissions)
    {
        return $this->permissions()->sync($permissions);
    }

    public function getPermissionsList()
    {
        return $this->permissions()->pluck('name')->toArray();
    }

    public function allPermissions()
    {
        $className = get_class($this);

        $perms = [];

        switch ($className) {
            case User::class:
                foreach ($this->permissions as $perm) {
                    if (!in_array($perm->name, $perms)) {
                        $perms[] = $perm->name;
                    }
                }
                
                foreach ($this->roles as $role) {
                    foreach ($role->permissions as $perm) {
                        if (!in_array($perm->name, $perms)) {
                            $perms[] = $perm->name;
                        }
                    }
                }
                break;
            case Team::class:
                foreach ($this->permissions as $perm) {
                    if (!in_array($perm->name, $perms)) {
                        $perms[] = $perm->name;
                    }
                }
                break;
            case TeamMemberPivot::class:
                foreach ($this->permissions as $perm) {
                    if (!in_array($perm->name, $perms)) {
                        $perms[] = $perm->name;
                    }
                }
                break;
            case Role::class:
                foreach ($this->permissions as $perm) {
                    if (!in_array($perm->name, $perms)) {
                        $perms[] = $perm->name;
                    }
                }
                break;
            default:
                $permissions = null;
        }

        return $perms;
    }
}