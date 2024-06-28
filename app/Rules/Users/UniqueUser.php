<?php

namespace App\Rules\Users;

use Illuminate\Contracts\Validation\Rule;

class UniqueUser implements Rule
{
    private $model;
    private $errorMessage = '';

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function passes($attribute, $value)
    {
        $user = $this->model->users()->where('users.id', $value)->first();
        if ($user) {
            $this->errorMessage = 'The user is already attached to this record.';
            return false;
        }
        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}