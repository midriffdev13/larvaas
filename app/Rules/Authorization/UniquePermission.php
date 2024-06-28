<?php

namespace App\Rules\Authorization;

use Illuminate\Contracts\Validation\Rule;

class UniquePermission implements Rule
{
    private $model;
    private $errorMessage = '';

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function passes($attribute, $value)
    {
        $permission = $this->model->permissions()->where('permissions.id', $value)->first();
        
        if ($permission) {
            $this->errorMessage = 'The permission is already attached to this record.';
            return false;
        }
        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}