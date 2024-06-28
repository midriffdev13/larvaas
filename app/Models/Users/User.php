<?php

namespace App\Models\Users;

use App\Models\Teams\TeamMemberPivot;
use App\Traits\Authorization\HasPermissions;
use App\Traits\Authorization\HasRoles;
use App\Traits\Users\UserFilament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// filament tenancy----
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Filament\Models\Contracts\HasAvatar;
use App\Models\Teams\Team;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable implements HasTenants, HasDefaultTenant, FilamentUser , MustVerifyEmail ,HasAvatar
{
    use
    HasApiTokens, 
    HasFactory,
    HasPermissions,
    HasRoles,
    HasSlug,
    Notifiable,
    SoftDeletes,
    UserFilament,
    TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'last_name',
    //     'email',
    //     'password',
        
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function getFilamentAvatarUrl(): ?string
    {
        return env('APP_URL').'/' .'storage/'. $this->profile_picture;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('email')
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

    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->latestTeam ;
    }
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class ,'team_members_pivot');
        // return $this->belongsToMany(Team::class, 'team_members_pivot', 'user_id', 'team_id');
    }
    
    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;

    }

    

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams()->whereKey($tenant)->exists();
    }


}
