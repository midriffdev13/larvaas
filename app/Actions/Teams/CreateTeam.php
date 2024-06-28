<?php

namespace App\Actions\Teams;

use App\Models\Teams\Team;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTeam
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $team = Team::create([
            'name' => $data['name'],
        ]);

        $team->members()->attach($data['owner']);
    }

    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'name' => $data['name'],
                'user' => $data['owner']->id,
            ],
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    
                ],
                'user' => [
                    'exists:users,id',
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
