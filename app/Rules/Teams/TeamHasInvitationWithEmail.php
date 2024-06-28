<?php

namespace App\Rules\Teams;

use Illuminate\Contracts\Validation\Rule;

class TeamHasInvitationWithEmail implements Rule
{
    private $team;
    private $errorMessage = '';

    public function __construct($team)
    {
        $this->team = $team;
    }

    public function passes($attribute, $value)
    {
        if (!$this->team->hasInvitationWithEmail($value)) {
            $this->errorMessage = 'The team does not have an invitation for this email.';
            return false;
        }
        
        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}