<?php

namespace App\Actions\Teams;

use App\Rules\Teams\UniqueMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachMember
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $data['team']->members()->attach($data['user']);
    }

    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'team' => $data['team']->id,
                'user' => $data['user']->id,
            ],
            [
                'team' => [
                    'exists:teams,id',

                ],
                'user' => [
                    'exists:users,id',
                    new UniqueMember($data['team']),
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
