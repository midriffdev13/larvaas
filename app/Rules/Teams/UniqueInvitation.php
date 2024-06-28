<?php

namespace App\Rules\Teams;

use Illuminate\Contracts\Validation\Rule;

class UniqueInvitation implements Rule
{
    private $team;
    private $errorMessage = '';

    public function __construct($team)
    {
        $this->team = $team;
    }

    public function passes($attribute, $value)
    {
        if ($this->team->invitations()->where('email', $value)->exists()) {
            $this->errorMessage = 'This email has already been invited to the team.';
            return false;
        }
        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}