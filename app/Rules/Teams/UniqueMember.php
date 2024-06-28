<?php

namespace App\Rules\Teams;

use Illuminate\Contracts\Validation\Rule;

class UniqueMember implements Rule
{
    private $team;
    private $errorMessage = '';

    public function __construct($team)
    {
        $this->team = $team;
    }

    public function passes($attribute, $value)
    {
        $member = $this->team->members()->where('users.id', $value)->exists();
        
        if ($member) {
            $this->errorMessage = 'This user is already a member of the team.';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->errorMessage;
    }
}