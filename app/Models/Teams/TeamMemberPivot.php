<?php

namespace App\Models\Teams;

use App\Models\Teams\Team;
use App\Models\Users\User;
use App\Traits\Authorization\HasPermissions;
use App\Traits\Authorization\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamMemberPivot extends Pivot
{
    use
    HasFactory,
    HasPermissions,
    HasRoles;
    
    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'team_members_pivot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'user_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}