<?php

namespace App\Models\Users\Authorization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPermissionPivot extends Pivot
{
    use
    HasFactory;

    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'user_permissions_pivot';
    
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