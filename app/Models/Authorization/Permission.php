<?php

namespace App\Models\Authorization;

use App\Models\Authorization\AuthorizationType;
use App\Models\Teams\Team;
use App\Traits\Authorization\HasRoles;
use App\Traits\Teams\HasMembers;
use App\Traits\Teams\HasTeams;
use App\Traits\Users\HasUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Permission extends Model
{
    use
    HasFactory,
    HasMembers,
    HasRoles,
    HasSlug,
    HasTeams,
    HasUsers,
    SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'team_id',
        'authorization_type_id',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function authorizationType()
    {
        return $this->belongsTo(AuthorizationType::class, 'authorization_type_id');
    }
}