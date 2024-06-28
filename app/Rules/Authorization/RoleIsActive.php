<?php

namespace App\Rules\Authorization;

use App\Models\Authorization\Role;
use Illuminate\Contracts\Validation\Rule;

class RoleIsActive implements Rule
{
    private $errorMessage = '';

    public function passes($attribute, $value)
    {
        $role = Role::find($value);
        if (!$role->is_active) {
            $this->errorMessage = 'The role is not active.';
            return false;
        }

        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}