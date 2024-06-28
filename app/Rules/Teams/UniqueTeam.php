<?php

namespace App\Rules\Teams;

use Illuminate\Contracts\Validation\Rule;

class UniqueTeam implements Rule
{
    private $model;
    private $errorMessage = '';

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function passes($attribute, $value)
    {
        $team = $this->model->teams()->where('teams.id', $value)->first();
        
        if ($team) {
            $this->errorMessage = 'The team is already attached to this record.';
            return false;
        }
        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}