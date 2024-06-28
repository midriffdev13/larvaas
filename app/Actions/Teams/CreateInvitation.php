<?php

namespace App\Actions\Teams;

use App\Models\Users\User;
use App\Rules\Teams\UniqueInvitation;
use App\Rules\Teams\UniqueMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateInvitation
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $data['team']->invitations()->create([
            'email' => $data['email'],
        ]);
    }

    private function validate($data): void
    {

        $member = $data['team']->getUserWithEmail($data['email']);

        $validator = Validator::make(
            [
                'email' => $data['email'],
                'user' => $member->id ?? null,
                'team' => $data['team']->id,
            ],
            [
                'email' => [
                    'required',
                    'email',
                    new UniqueInvitation($data['team']),
                ],
                'team' => [
                    'exists:teams,id',
                ],
                'user' => [
                    'sometimes',
                    new UniqueMember($data['team']),
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
