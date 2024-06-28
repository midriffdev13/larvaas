<?php

namespace App\Rules\Authorization;

use App\Models\Authorization\Permission;
use Illuminate\Contracts\Validation\Rule;

class PermissionIsActive implements Rule
{
    private $errorMessage = '';

    public function passes($attribute, $value)
    {
        $permission = Permission::find($value);
        if (!$permission->is_active) {
            $this->errorMessage = 'The permission is not active.';
            return false;
        }

        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}