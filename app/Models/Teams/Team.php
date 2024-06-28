<?php

namespace App\Models\Teams;

use App\Traits\Authorization\HasPermissions;
use App\Traits\Authorization\HasRoles;
use App\Traits\Teams\HasInvitations;
use App\Traits\Teams\HasMembers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// --tenant---
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Users\User;

class Team extends Model implements HasName
{
    use
        HasFactory,
        HasPermissions,
        HasRoles,
        HasSlug,
        SoftDeletes,
        HasInvitations,
        HasMembers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guard_name',
        'name',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // public function getCurrentTenantLabel(): string
    // {
    //     return 'Active Team';
    // }

    public function getFilamentName(): string
    {
        return ucfirst("{$this->name}'s") . ' ' . "Team";
    }

    public function team_invitation(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function team_member_pivot(): HasMany
    {
        return $this->hasMany(TeamMemberPivot::class);
    }


    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members_pivot');
        // return $this->belongsToMany(User::class, 'team_members_pivot', 'team_id', 'user_id');
    }
}