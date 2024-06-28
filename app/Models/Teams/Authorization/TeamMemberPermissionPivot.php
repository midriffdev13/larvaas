<?php

namespace App\Models\Teams\Authorization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamMemberPermissionPivot extends Pivot
{
    use
    HasFactory;

    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'team_member_permissions_pivot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'permission_id',
    ];
}
