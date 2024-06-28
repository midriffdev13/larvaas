<?php

namespace App\Traits\Teams;

use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use App\Models\Teams\Team;
use App\Models\Users\User;

trait HasTeams
{
    protected static $teamsPivotTables = [
        User::class => 'team_members_pivot',
        Role::class => 'team_roles_pivot',
        Permission::class => 'team_permissions_pivot',
    ];

    /**
     * Get all of the teams that the model belongs to.
     */
    public function teams()
    {
        $className = get_class($this);

        if (isset(self::$teamsPivotTables[$className])) {
            return $this->belongsToMany(Team::class, self::$teamsPivotTables[$className])->withTimestamps();
        }

        return null;
    }

    /**
     * Determine if the model belongs to any teams.
     */
    public function hasTeams(): bool
    {
        return $this->teams->isNotEmpty();
    }

    /**
     * Determine if the model belongs to the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function belongsToTeam($team): bool
    {
        return $this->teams->contains('id', $team->id);
    }

    /**
     * Determine if the model belongs to any team within the given teams.
     *
     * @param  mixed  $teams
     * @return bool
     */
    public function belongsToAnyTeam(...$teams): bool
    {
        return $this->teams->whereIn('id', collect($teams)->pluck('id'))->isNotEmpty();
    }

    /**
     * Determine if the model belongs to all of the given teams.
     *
     * @param  mixed  $teams
     * @return bool
     */
    public function belongsToAllTeams(...$teams): bool
    {
        return $this->teams->whereIn('id', collect($teams)->pluck('id'))->count() === count($teams);
    }

    /**
     * Attach the given team(s) to the model.
     *
     * @param  mixed  $teams
     * @return $this
     */
    public function attachTeams(...$teams)
    {
        $this->teams()->syncWithoutDetaching(
            collect($teams)->flatten()->map->getKey()->toArray()
        );

        return $this;
    }

    /**
     * Detach the given team(s) from the model.
     *
     * @param  mixed  $teams
     * @return $this
     */
    public function detachTeams(...$teams)
    {
        $this->teams()->detach(collect($teams)->flatten()->map->getKey()->toArray());

        return $this;
    }
}