<?php

namespace App\Rules\Authorization;

use Illuminate\Contracts\Validation\Rule;

class UniqueRole implements Rule
{
    private $model;
    private $errorMessage = '';

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function passes($attribute, $value)
    {
        $role = $this->model->roles()->where('roles.id', $value)->first();
        
        if ($role) {
            $this->errorMessage = 'The role is already attached to this record.';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}