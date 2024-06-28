<?php

namespace App\Actions\Users;

use App\Rules\Users\UniqueUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachUser
{
    use AsAction;

    public function handle($data): void
    {
        $this->validate($data);

        $this->doAction($data);
    }

    private function doAction($data): void
    {
        $data['model']->users()->attach($data['user']);
    }

    private function validate($data): void
    {
        $validator = Validator::make(
            [
                'model' => $data['model']->id,
                'user' => $data['user']->id,
            ],
            [
                'model' => [
                    'exists:' . $data['model']->getTable() . ',id',
                ],
                'users' => [
                    'exists:users,id',
                    new UniqueUser($data['model']),
                ],
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}